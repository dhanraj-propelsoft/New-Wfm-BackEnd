<?php

namespace App\Http\Controllers\Employee\Repository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Session;
use DB;

use App\Models\PersonModel\Person;
use App\Models\PersonModel\PersonMobile;
use App\Models\PersonModel\PersonEmail;
use App\Models\AdminModel\Salutation;
use App\Models\AdminModel\Gender;
use App\User;
use App\Models\AdminModel\BloodGroup;


class EmployeeRepository
{
    public function saveEmployee($model)
    {
        try {

            $result = DB::transaction(function () use ($model) {

                $model->save();
                return [
                    'message' => pStatusSuccess(),
                    'data' => $model
                ];
            });

            return $result;
        } catch (\Exception $e) {

            return [
                'message' => pStatusFailed(),
                'data' => $e
            ];
        }
    }
}