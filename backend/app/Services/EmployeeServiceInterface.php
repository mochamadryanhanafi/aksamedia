<?php

namespace App\Services;

interface EmployeeServiceInterface
{
    public function getAll($name = null, $divisionId = null);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
