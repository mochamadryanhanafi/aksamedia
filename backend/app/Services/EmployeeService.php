<?php

namespace App\Services;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Storage;

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
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('employees', 'public');
            $data['image'] = Storage::url($path);
        }
        
        return $this->employeeRepository->create($data);
    }

    public function update($id, array $data)
    {
        // Check if image update
         if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('employees', 'public');
            $data['image'] = Storage::url($path);
            
            // Optionally delete old image
            $employee = $this->employeeRepository->find($id);
            // logic to delete old image...
        }

        return $this->employeeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->employeeRepository->delete($id);
    }
}
