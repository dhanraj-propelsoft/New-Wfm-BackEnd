<?php

namespace App\http\Controllers\Wfm\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pWfmDBConnectionName();
    }
}
