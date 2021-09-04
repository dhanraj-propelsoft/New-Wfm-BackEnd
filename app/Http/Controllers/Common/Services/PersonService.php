<?php

namespace App\Http\Controllers\Common\Services;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Common\Repository\CommonRepository;
use App\Http\Controllers\Common\Services\CommonService;
use App\Http\Controllers\Common\Repository\PersonRepository;
use App\Notification\Service\SmsNotificationService;
use App\Notification\Service\EmailNotificationService;
use Hash;
use App\Http\Controllers\Common\Model\PersonVO;
use  App\Models\PersonModel\PersonMobile;
use App\Models\PersonModel\Person;
use  App\Models\PersonModel\PersonEmail;
use App\Http\Controllers\Entitlement\Controller\LoginController;


class PersonService
{
    public function __construct(CommonService $CommonService, PersonRepository $personRepo, LoginController  $loginController)
    {
        $this->commonService = $CommonService;
        $this->personRepo = $personRepo;
        $this->loginController = $loginController;
    }
    // public function personSave1($personDatas, $type)
    // {
    //     $userModel = false;
    //     if ($personDatas->password) {
    //         $userModel = true;
    //     }

    //     $datas = $personDatas->all();


    //     Log::info('PersonService->personSave:-Inside ' . json_encode($datas));
    //     if ($type == "person") {
    //         $otpValidate = $this->CommonService->getTmpPersonFile($datas);
    //         if ($otpValidate['message'] == pStatusSuccess()) {
    //             $personModel = $this->personCreation($datas, $userModel);
    //         } else {
    //             return $otpValidate;
    //         }
    //     } else {
    //         $personModel = $this->personCreation($datas, $userModel);
    //     }
    //     if ($userModel != true) {
    //         return [
    //             'message' => pStatusSuccess(),
    //             'data' => $personModel
    //         ];
    //     }
    //     if ($personModel['message'] == pStatusSuccess() && $userModel) {
    //         $res = $this->loginController->signin($datas->mobile_no, $datas->password);

    //         if ($res['status'] == 1) {

    //             Log::info('CommonService->signup:-return Success' . json_encode($res));

    //             return $res['data'];
    //         } else {

    //             Log::info('CommonService->signup:-return failed');

    //             return response()->json(['status' => 'Contact Admin!'], $this->unauthorised);
    //         }
    //     } elseif ($userModel != true) {
    //         # code...
    //     } else {
    //         return [
    //             'message' => pStatusSuccess(),
    //             'data' => "CONTACT ADMIN"
    //         ];
    //     }
    // OTP Validation in Json File


    //if ($otpValidate['message'] == pStatusSuccess() || $type == "employee") {

    // if ($datas['pId'] == "false") {
    //     $datas['pId'] = false;
    // }
    // $datas = (object)$datas;
    // $personModel = $this->convertToPersonModel($datas);

    // $personMobileModel = $this->convertToPersonMobileModel($datas);

    // $personEmailModel = $this->convertToPersonEmailModel($datas);

    // if ($userModel) {

    //     $userModel = $this->convertToUserModel($datas);
    // }
    // $result = $this->personRepo->savePersonModules($personModel, $personMobileModel, $personEmailModel, $userModel);

    // if ($userModel != true) {
    //     return [
    //         'message' => pStatusSuccess(),
    //         'data' => $personModel
    //     ];
    // }

    //Log::info('PersonService->personSave:-return personSave' . json_encode($result));
    //     if ($result['status'] == 1) {

    //         $res = $this->loginController->signin($datas->mobile_no, $datas->password);

    //         $res = app('App\Http\Controllers\Entitlement\Controller\LoginController')->signin($datas->mobile_no, $datas->password);

    //         Log::info('CommonService->signup:-return Signin' . json_encode($res));

    //         if ($res['status'] == 1) {

    //             Log::info('CommonService->signup:-return Success' . json_encode($res));

    //             return $res['data'];
    //         } else {

    //             Log::info('CommonService->signup:-return failed');

    //             return response()->json(['status' => 'Contact Admin!'], $this->unauthorised);
    //         }
    //     }
    // } else {

    //     return $otpValidate;
    // }

    //     Log::info('PersonService->personSave:-Return ' . json_encode($datas));
    // }
    public function personCreate($personDatas, $type)
    {
       
        $datas = $personDatas;
        $validator = $this->personValidator($datas);

        if ($validator->fails()) {

            return [
                'message' => pStatusFailed(),
                'data' => $validator->messages()->first()
            ];
        }

        if ($type == "person") {

          
            $otpVerification = $this->commonService->getTmpPersonFile($datas);
           
            if ($otpVerification['message'] == pStatusSuccess()) {
                $personModel = $this->personSave($datas);
            } else {
                return $otpVerification;
            }
        } else {
            $personModel = $this->personSave($datas);
        }
        return $personModel;
    }


    public function personSave($datas)
    {
        
        if ($datas['pId'] == "false") {
            $datas['pId'] = false;
        }

        $datas = (object)$datas;
        $personModel = $this->convertToPersonModel($datas);

        $personMobileModel = $this->convertToPersonMobileModel($datas);

        $personEmailModel = $this->convertToPersonEmailModel($datas);

        // if ($userModel) {

        //     $userModel = $this->convertToUserModel($datas);
        // }
        $result = $this->personRepo->savePersonModules($personModel, $personMobileModel, $personEmailModel,false);
        if ($result['message'] == pStatusSuccess()) {
            return [
                'message' => pStatusSuccess(),
                'data' => $result['data']
            ];
        } else {
            return [
                'message' => pStatusFailed(),
                'data' => $result['data']
            ];
        }
    }
    public function userCreation($userDatas)
    {
        
        $validator = $this->userValidator($userDatas);

        if ($validator->fails()) {

            return [
                'message' => pStatusFailed(),
                'data' => $validator->messages()->first()
            ];
        }

        $userDatas =(object)$userDatas;
        $userModel = $this->convertToUserModel($userDatas);
     
        $userSave = $this->personRepo->saveUser($userModel);
        if ($userSave['message'] == pStatusSuccess()) {
            $res = $this->loginController->signin($userDatas->mobile_no, $userDatas->password);


            if ($res['status'] == 1) {

                return $res['data'];
            } else {
                return response()->json(['status' => 'Contact Admin!'], $this->unauthorised);
            }
        } else {
            return [
                'message' => pStatusFailed(),
                'data' => $userSave['data']
            ];
        }
    }
    public function personValidator($data, $id = false)
    {

        $rule = [

            'first_name' => 'required',
            'mobile_no' => 'required',
            'email' => 'required'
        ];
        $validator = Validator::make($data, $rule);

        return $validator;
    }
    public function userValidator($data, $id = false)
    {

        $rule = [

            'person_id' => 'required',
            'mobile_no' => 'required',
            'email' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($data, $rule);

        return $validator;
    }
    public function convertToPersonModel($datas)
    {
        Log::info('PersonService->convertToPersonModel:-Inside ' . json_encode($datas));

        if ($datas->pId) {

            $model = Person::findOrFail($datas->pId);
        } else {

            $model = new Person;
        }
        $model->salutation  = $datas->salutation;
        $model->first_name = $datas->first_name;
        $model->middle_name = $datas->middle_name;
        $model->last_name = $datas->last_name;
        $model->alias = $datas->alias;
        $model->dob = $datas->dob;
        // $model->father_name = $datas->father_name;
        // $model->mother_name = $datas->mother_name;
        // $model->pan_no = $datas->pan_no;
        $model->gender_id = $datas->gender_id;
        $model->blood_group_id = $datas->blood_group_id;
        // $model->country_id = $datas->country_id;
        // $model->status_id = $datas->status_id;
        Log::info('PersonService->convertToPersonModel:-Return ' . json_encode($model));
        return $model;
    }
    public function convertToPersonMobileModel($datas)
    {
        Log::info('PersonService->convertToPersonMobileModel:-Inside ' . json_encode($datas));
        if ($datas->pId) {
            $model = PersonMobile::where('person_id', $datas->pId)->first();
        } else {
            $model = new PersonMobile;
        }

        $model->mobile_no = $datas->mobile_no;
        $model->status_id = '1';
        Log::info('PersonService->convertToPersonMobileModel:-return ' . json_encode($datas));
        return $model;
    }

    public function convertToPersonEmailModel($datas)
    {
        Log::info('PersonService->convertToPersonEmailModel:-Inside ' . json_encode($datas));
        if ($datas->pId) {
            $model = PersonEmail::where('person_id', $datas->pId)->first();
        } else {
            $model = new PersonEmail;
        }


        $model->email = $datas->email;
        $model->status_id = '1';
        Log::info('PersonService->convertToPersonEmailModel:-Return ' . json_encode($datas));
        return $model;
    }
    public function convertToUserModel($datas)
    {
        Log::info('PersonService->convertToUserModel:-Inside ' . json_encode($datas));

        $model = new User;

        $model->name = $datas->first_name . ' ' . $datas->middle_name . ' ' . $datas->last_name;
        $model->mobile = $datas->mobile_no;
        $model->email = $datas->email;
        $model->password = Hash::make($datas->password);
        $model->person_id =$datas->person_id;
        //$model->otp =$datas->otp;
        // $model->otp_time = $datas->otp_time;
        // $model->otp_sent = $datas->otp_sent;
        // $model->is_active = $datas->is_active;
        $model->status = 1;
        // $model->remember_token = $datas->remember_token;
        Log::info('PersonService->convertToUserModel:-Return ' . json_encode($model));
        return $model;
    }
}
