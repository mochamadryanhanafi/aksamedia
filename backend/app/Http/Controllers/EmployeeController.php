<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        $employees = $this->employeeService->getAll($request->name, $request->division_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengambil data karyawan',
            'data' => [
                'employees' => $employees->items(),
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ],
        ]);
    }

    public function store(\App\Http\Requests\StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        
        $data['division_id'] = $data['division'];
        unset($data['division']);

        $this->employeeService->create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan data karyawan',
        ], 201);
    }

    public function update(\App\Http\Requests\UpdateEmployeeRequest $request, $id)
    {
        $data = $request->validated();
        
        $data['division_id'] = $data['division'];
        unset($data['division']);

        $this->employeeService->update($id, $data);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah data karyawan',
        ]);
    }

    public function destroy($id)
    {
        $this->employeeService->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data karyawan',
        ]);
    }
}
