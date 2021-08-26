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
}
