<?php

namespace App\Http\Controllers\Organization\Model;

use Illuminate\Database\Eloquent\Model;

class OrganizationPerson extends Model
{
	protected $connection;

	protected $table = "organization_person";

    public function __construct()
    {
        parent::__construct();
        $this->connection = "mysql2";
    }
}
