<?php

namespace App\Models\OrganizationModel;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pBusinessDBConnectionName();
    }
    public function OrganizationAddress(){

        return $this->hasOne('App\Models\OrganizationModel\OrganizationAddress');
    }

    public function OrganizationCategory(){

        return $this->hasOne('App\Models\OrganizationModel\OrganizationCategory','id','organization_category_id');
    }

    public function OrganizationOwnership(){

        return $this->hasOne('App\Models\OrganizationModel\OrganizationOwnership','id','organization_ownership_id');
    }
    public function OrganizationPerson(){

        return $this->hasOne('App\Models\OrganizationModel\OrganizationPerson','organization_id','id');
    }

    public function OrganizationPersonlist(){

        return $this->hasMany('App\Models\OrganizationModel\OrganizationPerson','organization_id','id');
    }
}
