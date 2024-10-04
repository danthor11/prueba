<?php

namespace App\Http\Controllers;

use App\Jobs\TransferDataBatchJob;
use App\Models\Employee;
use App\Models\EmployeeBackup;
use Hamcrest\Type\IsInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class MultiBatchController extends Controller
{
    public function index()
    {
        return [
            "table_1" => Employee::all(),
            "table_2" => EmployeeBackup::all(),
        ];
    }


    public function store(Request $request)
    {
        $employee = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'birthday' => 'required'
        ]);

        return Employee::create($employee);
    }


    public function show(string $batches)
    {
        if (!is_numeric($batches) || intval($batches) != $batches) {
            return response()->json(['error' => 'El parámetro n-batches debe ser un entero.'], 400);
        }

        $employeesBatches = Employee::all()->chunk($batches);
        foreach ($employeesBatches as $batch) {
            TransferDataBatchJob::dispatch($batch);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Data transfer initiated',
            'batches' => $employeesBatches->count()
        ]);
    }

    public function getEmployees()
    {
        return Employee::all();
    }

    public function getEmployeesBackup()
    {
        return EmployeeBackup::all();
    }
    public function checkQueueStatus()
    {
        $pending = Queue::size('default');
        return response()->json([
            'pending_jobs' => $pending,
            'status' => $pending == 0 ? 'All jobs are processed' : 'Jobs are still working'
        ]);
    }
}
