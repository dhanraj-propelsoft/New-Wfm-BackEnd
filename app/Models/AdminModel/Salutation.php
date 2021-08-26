<?php

namespace App\Models\AdminModel;

use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pCommonDBConnectionName();
    }
}
