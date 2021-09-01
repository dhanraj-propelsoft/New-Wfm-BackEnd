<?php

namespace App\Models\PersonModel;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

        protected $table = "persons";
        protected $connection;

        public function __construct()
        {
                parent::__construct();
                $this->connection = pCommonDBConnectionName();
        }

        public function personMobile()
        {
                return $this->hasOne('App\Http\Controllers\Common\Model\PersonMobile', 'person_id', 'id');
        }
        public function personEmail()
        {
                return $this->hasOne('App\Http\Controllers\Common\Model\PersonEmail', 'person_id', 'id');
        }
        public function user()
        {
                return $this->hasOne('App\Models\User', 'person_id', 'id');
        }
}
