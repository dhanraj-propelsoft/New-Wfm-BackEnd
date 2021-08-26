<?php

namespace App\Models\AdminModel;

use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pCommonDBConnectionName();
    }
}
