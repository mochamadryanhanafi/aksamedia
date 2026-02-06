<?php

namespace App\Http\Controllers;

use App\Services\NilaiServiceInterface;
use Illuminate\Http\JsonResponse;

class NilaiController extends Controller
{
    protected $nilaiService;

    public function __construct(NilaiServiceInterface $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }

    public function nilaiRT(): JsonResponse
    {
        $data = $this->nilaiService->getNilaiRT();
        return response()->json($data);
    }

    public function nilaiST(): JsonResponse
    {
        $data = $this->nilaiService->getNilaiST();
        return response()->json($data);
    }
}
