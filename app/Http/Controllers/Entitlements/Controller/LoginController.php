<?php

namespace App\Http\Controllers\Entitlement\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Helper;

class LoginController extends Controller
{
	public $successStatus = 200;
	public $unauthorised = 401;
	private $orgId;

	public function login(Request $request) 
	{
		
		
		$datas = $request->all();
		$mobile_no = $datas['mobile_no'];
		$password = $datas['password'];
	
			if(Auth::attempt(['mobile' => $mobile_no, 'password' => $password, 'status' => 1])) {
				$user = Auth::user();

			$success['status'] = 1;
			$success['user'] =  $user;
			$success['person_id'] =  $user->person_id;
			$success['image'] =  "";
			$success['token'] =  $user->createToken($user->name)->accessToken;
			$success['firstOrg'] =  0;

			 $result = [
				'status'=>1,
				'data'=>$success
			];

			}else{
				$result = [
				'status'=>0,
				'data'=>"Wrong Credentials"
			];

			
			}
			return $result;
	}
		
		

	
}
