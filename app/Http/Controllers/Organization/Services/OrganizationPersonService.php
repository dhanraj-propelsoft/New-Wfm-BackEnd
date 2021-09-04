<?php

namespace App\Http\Controllers\Organization\Services;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\OrganizationModel\Organization;
use App\Models\OrganizationModel\OrganizationPerson;
use App\Http\Controllers\Organization\Model\OrganizationVO;
use Hash;
use App\Http\Controllers\Organization\Repository\OrganizationRepository;
use App\Http\Controllers\Employee\Service\EmployeeService;

class OrganizationPersonService
{
    public function __construct(OrganizationRepository $repo)
        {
                $this->repo = $repo;
              
        }
    public function organizationPersonCreation($datas)
        {
              
                $model = OrganizationPerson::where('person_id', $datas->person_id)->where('organization_id', $datas->organization_id)->first();
             
                if (!$model) {
                        $orgPersonModel = $this->convertToOrganizationPersonModel1($datas->person_id, $datas->organization_id);
                     
                        $saveOrgPersonModel = $this->repo->saveOrgPerson($orgPersonModel);
                       
                        if ($saveOrgPersonModel['message'] == pStatusSuccess()) {
                                return [
                                        'message' => pStatusSuccess(),
                                        'data' => $saveOrgPersonModel['data']
                                ];
                        } else {
                                return [
                                        'message' => pStatusFailed(),
                                        'data' => $saveOrgPersonModel['data']
                                ];
                        }
                } else {
                        return [
                                'message' => pStatusSuccess(),
                                'data' => $model
                        ];
                }
        }
        public function convertToOrganizationPersonModel1($personId, $orgId = false)
        {
                $model = new OrganizationPerson;
                $model->person_id = $personId;
                $model->organization_id = $orgId;
                return $model;
        }
}