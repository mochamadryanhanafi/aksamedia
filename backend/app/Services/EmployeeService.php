<?php

namespace App\Services;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class EmployeeService implements EmployeeServiceInterface
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAll($name = null, $divisionId = null)
    {
        return $this->employeeRepository->getAll($name, $divisionId);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $filePath = null;

            try {
                if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $filePath = $data['image']->store('employees', 'public');
                    $data['image'] = Storage::disk('public')->url($filePath);
                }
                
                return $this->employeeRepository->create($data);
            } catch (Exception $e) {
                if ($filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                throw $e;
            }
        });
    }

    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $employee = $this->employeeRepository->find($id);
            $newFilePath = null;
            $oldImage = $employee->image;

            try {
                if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $newFilePath = $data['image']->store('employees', 'public');
                    $data['image'] = Storage::disk('public')->url($newFilePath);
                }

                $updated = $this->employeeRepository->update($id, $data);

                if ($newFilePath && $oldImage) {
                    $this->deleteOldImage($oldImage);
                }

                return $updated;
            } catch (Exception $e) {
                if ($newFilePath) {
                    Storage::disk('public')->delete($newFilePath);
                }
                throw $e;
            }
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $employee = $this->employeeRepository->find($id);
            
            $deleted = $this->employeeRepository->delete($id);

            if ($deleted && $employee->image) {
                $this->deleteOldImage($employee->image);
            }

            return $deleted;
        });
    }

    private function deleteOldImage($imageUrl)
    {
        if (!$imageUrl) {
            return;
        }

        $parsedPath = parse_url($imageUrl, PHP_URL_PATH);
        $relativePath = Str::after($parsedPath, '/storage/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}