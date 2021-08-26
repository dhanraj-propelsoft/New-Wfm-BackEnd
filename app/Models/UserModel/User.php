<?php

namespace App\Models\UserModel;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pCommonDBConnectionName();
    }
}
