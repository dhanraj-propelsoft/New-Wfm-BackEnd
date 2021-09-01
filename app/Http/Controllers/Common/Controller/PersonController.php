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
        $userModel = false;
        if($request->password){
            $userModel = true;
        }

        Log::info('PersonController->Signup:-Inside ' . json_encode($request->all()));
        $response = $this->personService->personSave($request->all(), $userModel);
        Log::info('PersonController->Signup:-Return ' . json_encode($response));

        return response()->json($response);
    }
}
