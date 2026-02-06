<?php

namespace App\Repositories\Interfaces;

interface DivisionRepositoryInterface
{
    public function getAll($search = null, $perPage = 10);
    // Add other methods if needed
}
