<?php

namespace App\Http\Controllers\Employee\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Employee\Service\EmployeeService;

class EmployeeController extends Controller
{
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
        
    }


    public function store(Request $request)
    {
        
        $response = $this->employeeService->employeeStore($request);
        dd($response);
        return response()->json($response);

    }
}
