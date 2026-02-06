<?php

namespace App\Http\Controllers;

use App\Services\DivisionService;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    protected $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function index(Request $request)
    {
        $divisions = $this->divisionService->getAll($request->name);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data divisi',
            'data' => [
                'divisions' => $divisions->items(),
            ],
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'per_page' => $divisions->perPage(),
                'total' => $divisions->total(),
            ],
        ]);
    }
}
