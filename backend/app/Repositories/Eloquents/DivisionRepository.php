<?php

namespace App\Repositories\Eloquents;

use App\Models\Division;
use App\Repositories\Interfaces\DivisionRepositoryInterface;

class DivisionRepository implements DivisionRepositoryInterface
{
    public function getAll($search = null, $perPage = 10)
    {
        return Division::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate($perPage);
    }
}
