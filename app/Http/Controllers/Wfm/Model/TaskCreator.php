<?php

namespace App\Http\Controllers\Wfm\Model;

use Illuminate\Database\Eloquent\Model;

class TaskCreator extends Model
{
    protected $connection;
    
    public function __construct()
    {
        parent::__construct();
        $this->connection = pWfmDBConnectionName();
    }

    public function HrmEmployee(){

    	return $this->hasOne('App\HrmEmployee','id','creator_id');
    }

    public function Person(){

    	return $this->hasOne('App\Person','id','creator_id');
    }

    
}
