<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreemployeeRequest;
use App\Http\Requests\UpdateemployeeRequest;
use App\Services\GoogleSheetsService;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class EmployeeController extends Controller
{
    protected $googleSheetsService;
    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function index()
    {
        return Employee::all();
    }

    public function uploadToSheets()
    {
        date_default_timezone_set("America/Caracas");
        $data = DB::table("employees")->select("email", "name", "emp_title", "salary", "emp_stated", "birthday")->get()->toArray();
        $res = $this->googleSheetsService->uploadData($data);
        return response()->json(['message' => 'Data uploaded successfully', "uri_document" => 'https://docs.google.com/spreadsheets/d/' . $res]);
    }

    public function readSheet()
    {
        return response()->json($this->googleSheetsService->readData());
    }

    public function store(StoreemployeeRequest $request)
    {
        $validate = $request->validate();
        $new_employee = Employee::create($validate);
        return $new_employee;
    }

    public function show(Employee $employee)
    {
        return $employee;
    }

    public function update(UpdateemployeeRequest $request, Employee $employee)
    {
        $validated = $request->validate();
        $employee->name = $validated["name"];
        $employee->email = $validated["email"];
        $employee->salary = $validated["salary"];
        $employee->emp_started = $validated["emp_started"];
        $employee->birthday = $validated["birthday"];
        $employee->save();
        return $employee;
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return true;
    }
}
