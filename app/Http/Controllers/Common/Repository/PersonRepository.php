<?php

namespace App\Http\Controllers\Common\Repository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Session;
use DB;
use App\Http\Controllers\Common\Repository\PersonRepositoryInterface;
use App\Models\PersonModel\Person;
use App\Models\PersonModel\PersonMobile;
use App\Models\PersonModel\PersonEmail;
use App\AdminModel\Salutation;
use App\Gender;
use App\User;
use App\BloodGroup;


class PersonRepository implements PersonRepositoryInterface
{
    public function savePerson(Person $model)
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
    public function saveUser($model)
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
    public function savePersonEmail(Person $model)
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
    public function savePersonMobile(Person $model)
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
    public function savePersonModules($personModel, $personMobilemodel, $personEmailModel, $usermodel)
    {

        try {

            $result = DB::transaction(function () use ($personModel, $personMobilemodel, $personEmailModel, $usermodel) {


                $personModel->save();

                $personModel->personMobile()->save($personMobilemodel);

                $personModel->personEmail()->save($personEmailModel);
                if ($usermodel) {
                    $personModel->user()->save($usermodel);
                }


                // Log::info('TaskRepository->TaskSave:Success-'.json_encode($model));   
                return [
                    'status' => 1,
                    'message' => pStatusSuccess(),
                    'data' => $personModel
                ];
            });

            return $result;
        } catch (\Exception $e) {

            // Log::info('TaskRepository->TaskSave:Error-'.json_encode($e)); 

            return [
                'status' => 0,
                'message' => $e,
                'data' => ""
            ];
        }
    }
}
