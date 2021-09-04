<?php

namespace App\Http\Controllers\Employee\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Common\Services\PersonService;

use App\Http\Controllers\Employee\Service\EmployeeService1;

class EmployeeController1 extends Controller
{
    public function __construct(EmployeeService1 $employeeService)
    {
        $this->employeeService = $employeeService;
        
    }
    public function employeeCreation(Request $request)
    {
      
        $response = $this->employeeService->employeeStore($request->all());
       
        return response()->json($response);
    }
}