<?php

namespace App\Http\Controllers\Wfm\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $connection;
    
    public function __construct()
    {
        parent::__construct();
        $this->connection = pWfmDBConnectionName();
    }
}
