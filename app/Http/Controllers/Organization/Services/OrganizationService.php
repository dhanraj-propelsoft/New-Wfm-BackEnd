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

class OrganizationService
{

        /** 
         * * To connect Repo **
         */
        public function __construct(OrganizationRepository $repo)
        {
                $this->repo = $repo;
        }


        public function findAll()
        {



                Log::info('ProjectMasterService->findAll:-Inside');


                $models = $this->repo->findAll();


                $entities = collect($models)->map(function ($model) {

                        return $this->convertToVO($model);
                });


                return ['status' => 1, 'message' => 'Category Data has been get Successfully!', 'data' => $entities];
        }
        public function save($request)
        {
             
                Log::info('OrganizationService->save:-Inside ' . json_encode($request));

                $rule = $this->validator($request);

                $validators = Validator::make($request, $rule);

                if ($validators->fails()) {
                        return [
                                'status' => 0,
                                'message' => $validators->messages()->first(),

                        ];
                }

                $model = $this->convertToModel($request);


                $organizationPersonmodel = $this->convertToOrganizationPersonModel1(Auth::user()->person_id);


                $storedModel = $this->repo->save($model, $organizationPersonmodel);

                Log::info('ProjectMasterService->save:-Return ' . json_encode($storedModel));

                return $storedModel;
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
        public function convertToOrganizationPersonModel1($personId, $orgId=false)
        {
                $model = new OrganizationPerson;
                $model->person_id = $personId;
                $model->organization_id = $orgId;
                return $model;
        }
        public function findById($id)
        {

                Log::info('OrganizationService->findById:-Inside ');

                $model = $this->repo->findById($id);

                Log::info('OrganizationService->findById:-Return');

                return $model;

                // return $this->convertToVO($model);

        }
        public function getOrgMasterData()
        {

                Log::info('OrganizationService->findById:-Inside ');

                $res = $this->repo->getOrgMasterData();

                Log::info('OrganizationService->findById:-Return');

                return $res;

                // return $this->convertToVO($model);

        }

        public function convertToVO($model = false)
        {

                $vo = new OrganizationVO($model);

                return $vo;
        }
        public function validator($data)
        {
                Log::info('OrganizationService->validator: Inside' . json_encode($data));

                $rule = ['pOrganizationName' => 'required', 'pCategoryId' => 'required', 'pOwnershipId' => 'required'];
                Log::info('OrganizationService->validator: Return' . json_encode($rule));

                return $rule;
        }

        public function convertToModel($modelData)
        {


                $data = (object)$modelData;

                // if($id)
                // {
                //     $model = $this->repo->findById($id); 

                // }
                // else
                // {
                $model = new Organization;
                // } 
                $model->organization_name = $data->pOrganizationName;
                $model->unit_name = $data->pUnitName;
                $model->alias = $data->pAlias;
                $model->organization_category_id = $data->pCategoryId;
                $model->organization_ownership_id = $data->pOwnershipId;

                return $model;
        }

        public function convertToOrganizationPersonModel()
        {


                $model = new OrganizationPerson;

                $model->person_id = Auth::user()->person_id;

                return $model;
        }
}
