<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


header("Access-Control_Allow_Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', 'App\Http\Controllers\Entitlement\Controller\LoginController@login');


//new Api Started By Dhana

Route::get('getPersonByMobileNo/{mobileNo}', 'App\Http\Controllers\Common\Controller\CommonController@getPersonByMobileNo');
Route::post('wfmlogin', 'App\Http\Controllers\Entitlement\Controller\LoginController@login');
Route::post('sendOtpForgetPassword', 'App\Http\Controllers\Common\Controller\CommonController@sendOtp');
Route::post('OTPVerification', 'App\Http\Controllers\Common\Controller\CommonController@OTPVerification');
Route::post('updatePassword', 'App\Http\Controllers\Common\Controller\CommonController@updatePassword');
Route::post('createPersonTmpFile', 'App\Http\Controllers\Common\Controller\CommonController@createPersonTmpFile');
Route::post('getTmpPersonFile', 'App\Http\Controllers\Common\Controller\CommonController@getTmpPersonFile');

Route::post('SignUp', 'App\Http\Controllers\Common\Controller\CommonController@signup');

Route::post('updatePassword_and_login', 'App\Http\Controllers\Common\Controller\CommonController@updatePassword_and_login');
Route::post('get_persondetails', 'App\Http\Controllers\Common\Controller\CommonController@persondetails');

Route::get('finddataByPersonId/{id}', 'App\Http\Controllers\Common\Controller\CommonController@finddataByPersonId');

Route::post('sendOtpPerson', 'App\Http\Controllers\Common\Controller\CommonController@sendOtpPerson');

Route::get('get_account_list/{mobile_no}', 'App\Http\Controllers\Common\Controller\CommonController@get_account_list');

Route::post('sendotp_email', 'App\Http\Controllers\Common\Controller\CommonController@sendotp_email');

Route::post('verifiy_email_otp', 'App\Http\Controllers\Common\Controller\CommonController@verifiy_email_otp');


//Ended Peron Related Api By Dhana



Route::post('signup', 'App\Http\Controllers\Common\Controller\CommonController@signup');

Route::post('createPersonTmpFile', 'App\Http\Controllers\Common\Controller\CommonController@createPersonTmpFile');
Route::post('getTmpPersonFile', 'App\Http\Controllers\Common\Controller\CommonController@getTmpPersonFile');

Route::post('personCreation', 'App\Http\Controllers\Common\Controller\PersonController@personCreation');

Route::post('userCreation', 'App\Http\Controllers\Common\Controller\PersonController@userCreation');

// include_once ('login-api.php');
Route::group(['middleware' => ['auth:api']], function () {

    Route::resource('employee', 'App\Http\Controllers\Employee\Controller\EmployeeController');

    Route::post('logout', 'App\Http\Controllers\Entitlement\Controller\LoginController@logout');
    include_once('organization-api.php');
});
