<?php

namespace App\Http\Controllers\Wfm\Model;

use Illuminate\Database\Eloquent\Model;

class TaskFollower extends Model
{

    protected $fillable=["task_id","follower_id","organization_id"];

    protected $connection;
    
    public function __construct()
    {
        parent::__construct();
        $this->connection = pWfmDBConnectionName();
    }

    public function HrmEmployee(){

    	return $this->hasOne('App\HrmEmployee','id','follower_id');
    }
}
