<?php

namespace App\Http\Controllers\Common\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Common\Services\PersonService;

class PersonController extends Controller
{
    /**
     * * To connect service **
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    public function personCreation(Request $request)
    {
     

        $type = "person";
        Log::info('PersonController->Signup:-Inside ' . json_encode($request->all()));
        $response = $this->personService->personCreate($request, $type);
        Log::info('PersonController->Signup:-Return ' . json_encode($response));

        return response()->json($response);
    }
    public function userCreation(Request $request)
    {

        $type = "person";
        Log::info('PersonController->Signup:-Inside ' . json_encode($request->all()));
        $response = $this->personService->userCreation($request->all());
        Log::info('PersonController->Signup:-Return ' . json_encode($response));

        return response()->json($response);
    }
}
