<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getAll($name = null, $divisionId = null, $perPage = 10);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function find($id);
}
