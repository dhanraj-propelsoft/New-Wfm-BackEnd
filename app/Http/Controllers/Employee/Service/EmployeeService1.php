<?php

namespace App\Http\Controllers\Employee\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Common\Services\PersonService;
use App\Models\AdminModel\HrmEmployee;
use App\Models\PersonModel;
use App\Http\Controllers\Organization\Services\OrganizationService;
use App\Http\Controllers\Organization\Services\OrganizationPersonService;
use App\Http\Controllers\Employee\Service\EmployeeService;
use App\Http\Controllers\Employee\Repository\EmployeeRepository;

class EmployeeService1
{
    public function __construct(PersonService $personService,EmployeeRepository $employeeRepository,OrganizationPersonService $orgPersonService)
    {
        $this->personService = $personService;
       
        $this->employeeRepo =$employeeRepository;
        $this->orgPersonService = $orgPersonService;
    }

    public function employeeStore($datas, $id = false)
    {



        // $datas = (object)$datas;
        $type = "employee";
       
        $storePerson = $this->personService->personCreate($datas, $type);

       

        if ($storePerson['message'] == pStatusSuccess()) {
            $personDatas = $storePerson['data'];

            $employeeModel = $this->employeeCreation($datas, $personDatas->id);
           
            if ($employeeModel['message'] == pStatusSuccess()) {
             
                $organizationPerson = $this->orgPersonService->organizationPersonCreation($employeeModel['data']);
           
              
                if ($organizationPerson['message'] == pStatusSuccess()) {
                    return [
                        'message' => pStatusSuccess(),
                        'data' => $organizationPerson['data']
                    ];
                } else {
                    return [
                        'message' => pStatusFailed(),
                        'data' => $organizationPerson['data']
                    ];
                }
            } else {
                return [
                    'message' => pStatusFailed(),
                    'data' => $employeeModel['data']
                ];
            }
        } else {
            return [
                'message' => pStatusFailed(),
                'data' => "CONTACT ADMIN"
            ];
        }
    }
    public function employeeCreation($orginalDatas, $personId)
    {

        $employeeModel =  $this->convertToHrmEmployee($orginalDatas, $personId);
        $storeEmployee = $this->employeeRepo->saveEmployee($employeeModel);
        return $storeEmployee;
    }
    public function convertToHrmEmployee($datas, $personId)
    {

        $datas = (object)$datas;


        Log::info('PersonService->convertToPersonEmailModel:-Inside ' . json_encode($datas));
        if ($personId) {
            $model = HrmEmployee::where('person_id', $personId)->where('organization_id', $datas->organization_id)->first();
            if (!$model) {
                $model = new HrmEmployee;
            }
        } else {
            $model = new HrmEmployee;
        }

        $model->person_id = $personId;
        $model->employee_code = $datas->employee_code;
        $model->emergency_contact_no = $datas->emergency_contact_no;
        $model->organization_id = $datas->organization_id;

        Log::info('PersonService->convertToPersonEmailModel:-Return ' . json_encode($datas));
        return $model;
    }
}
