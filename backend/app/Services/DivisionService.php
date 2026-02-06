<?php

namespace App\Services;

use App\Repositories\Interfaces\DivisionRepositoryInterface;

class DivisionService implements DivisionServiceInterface
{
    protected $divisionRepository;

    public function __construct(DivisionRepositoryInterface $divisionRepository)
    {
        $this->divisionRepository = $divisionRepository;
    }

    public function getAll($search = null)
    {
        return $this->divisionRepository->getAll($search);
    }
}
