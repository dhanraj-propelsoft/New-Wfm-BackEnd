<?php

namespace App\Http\Controllers\Organization\Repository;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Models\User;
use App\Models\OrganizationModel\Organization;
use App\Models\OrganizationModel\OrganizationCategory;
use App\Models\OrganizationModel\rganizationOwnership;

class OrganizationRepository 
{
    

    public function findAll()
    {   
        
       Log::info('ProjectMasterRepository->findAll:-Inside ');
        $result =  Organization::with('OrganizationAddress','OrganizationCategory','OrganizationOwnership','OrganizationPersonlist')
            ->whereHas('OrganizationPersonlist', function($q){
                $q->where('person_id', Auth::user()->person_id);
            })->get();
       Log::info('ProjectMasterRepository->findAll:-Return '. json_encode($result));
       return $result;
        
    }
    public function save($model,$OrganizationPersonmodel)
    { 

           try {
            
            $result = DB::transaction(function () use ($model,$OrganizationPersonmodel) {


                $model->save();

                $model->OrganizationPerson()->save($OrganizationPersonmodel);

                return [
                    'status' => 1,
                    'message'=>pStatusSuccess(),
                    'data' => $model
                ];
            });
           
            return $result;
        } catch (\Exception $e) { 
            return [
                'status' => 0,
                'message' =>pStatusFailed(),
                'data' => $e
            ];
        }
    
      
    } 

    public function findById($id)
    {
        Log::info('OrganizationRepository->findById:-Inside ');

        $result =  Organization::findOrFail($id);
       

        Log::info('OrganizationRepository->findById:-Return '. json_encode($result));

       return $result;
              
    }  

    public function getOrgMasterData()
    {
        Log::info('OrganizationRepository->findById:-Inside ');

        $category =  OrganizationCategory::get();


        $ownership =  OrganizationOwnership::get();
       

        Log::info('OrganizationRepository->findById:-Return ');

       return ['status'=>1,'CategoryData'=>$category,'ownershipData'=>$ownership];
              
    }
       
   
}
