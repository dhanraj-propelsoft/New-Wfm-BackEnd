<?php

namespace App\Models\PersonModel;

use Illuminate\Database\Eloquent\Model;

class PersonQualification extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pCommonDBConnectionName();
    }
}
