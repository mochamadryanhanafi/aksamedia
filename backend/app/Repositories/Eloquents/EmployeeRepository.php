<?php

namespace App\Repositories\Eloquents;

use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll($name = null, $divisionId = null, $perPage = 10)
    {
        return Employee::with('division')
            ->when($name, function ($query, $name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->when($divisionId, function ($query, $divisionId) {
                $query->where('division_id', $divisionId);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update($id, array $data)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        return $employee->delete();
    }
    
    public function find($id)
    {
        return Employee::with('division')->findOrFail($id);
    }
}
