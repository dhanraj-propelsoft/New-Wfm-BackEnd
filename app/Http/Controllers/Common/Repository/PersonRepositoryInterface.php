<?php
namespace App\Http\Controllers\Common\Repository;
use App\Models\PersonModel\Person;
interface PersonRepositoryInterface
{
    public function savePerson(Person $model);
}