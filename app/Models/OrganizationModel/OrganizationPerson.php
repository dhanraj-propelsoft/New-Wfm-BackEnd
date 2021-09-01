<?php

namespace App\Models\OrganizationModel;

use Illuminate\Database\Eloquent\Model;

class OrganizationPerson extends Model
{
    protected $table = "organization_person";
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pBusinessDBConnectionName();
    }
}
