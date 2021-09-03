<?php

namespace App\Http\Controllers\Organization\Model;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pBusinessDBName();
    }

    public function OrganizationAddress(){

        return $this->hasOne('App\Http\Controllers\Organization\Model\OrganizationAddress');
    }

    public function OrganizationCategory(){

        return $this->hasOne('App\Http\Controllers\Organization\Model\OrganizationCategory','id','organization_category_id');
    }

    public function OrganizationOwnership(){

        return $this->hasOne('App\Http\Controllers\Organization\Model\OrganizationOwnership','id','organization_ownership_id');
    }
    public function OrganizationPerson(){

        return $this->hasOne('App\Http\Controllers\Organization\Model\OrganizationPerson','organization_id','id');
    }

    public function OrganizationPersonlist(){

        return $this->hasMany('App\Http\Controllers\Organization\Model\OrganizationPerson','organization_id','id');
    }
}
