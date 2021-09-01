<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Organization;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = pCommonDBConnectionName();
    }
    use HasApiTokens, Notifiable;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'is_active', 'created_at', 'updated_at', 'status', 'person_id'
    ];


}
