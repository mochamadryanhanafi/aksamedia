<?php

namespace App\Services;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $path = $data['image']->store('employees', 'public');
                $data['image'] = Storage::url($path);
            }
            
            return $this->employeeRepository->create($data);
        });
    }

    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $employee = $this->employeeRepository->find($id);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $this->deleteOldImage($employee->image);

                $path = $data['image']->store('employees', 'public');
                $data['image'] = Storage::url($path);
            }

            return $this->employeeRepository->update($id, $data);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $employee = $this->employeeRepository->find($id);
            
            if ($employee) {
                $this->deleteOldImage($employee->image);
            }

            return $this->employeeRepository->delete($id);
        });
    }

    private function deleteOldImage($imageUrl)
    {
        if (!$imageUrl) {
            return;
        }

        $path = str_replace(url('/storage') . '/', '', $imageUrl);

        $parsedPath = parse_url($imageUrl, PHP_URL_PATH);
        $relativePath = Str::after($parsedPath, '/storage/');

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
