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
use App\Http\Controllers\Employee\Repository\EmployeeRepository;
use App\Http\Controllers\Organization\Services\OrganizationService;

class EmployeeService
{
    public function __construct(
        PersonService $personService,
        EmployeeRepository $employeeRepo,
        OrganizationService $organizationService
    ) {
        $this->personService = $personService;
        $this->employeeRepo = $employeeRepo;
        $this->organizationService = $organizationService;
    }
    public function employeeStore($datas, $id = false)
    {

        // $datas = (object)$datas;
        $type = "employee";
        $storePerson = $this->personService->personCreate($datas, $type);
       
        $orginalDatas = (object)$datas->all();

        if ($storePerson['message'] == pStatusSuccess()) {
            $personDatas= $storePerson['data'];
         
            $employeeModel =  $this->convertToHrmEmployee($orginalDatas,$personDatas->id);
            $storeEmployee = $this->employeeRepo->saveEmployee($employeeModel);
            if ($storeEmployee['message'] == pStatusSuccess()) {
                $organizationPerson = $this->organizationService->organizationPersonCreation($storeEmployee['data']);
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
                    'data' => $storeEmployee['data']
                ];
            }
            
        } else {
            return [
                'message' => pStatusFailed(),
                'data' => "CONTACT ADMIN"
            ];
        }
    }
    public function convertToHrmEmployee($datas,$personId)
    {

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
