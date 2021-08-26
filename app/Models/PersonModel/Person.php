<?php

namespace App\Models\PersonModel;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pCommonDBConnectionName();
    }
}
