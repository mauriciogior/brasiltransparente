<?php

class PublicController extends BaseController {

	public static function getAuth()
	{
		$auth = array();

		if(Auth::user())
		{
			if(Auth::user()->enterprise_id)
			{
				$auth["enterprise"] = true;
				$auth["user"]	    = false;
			}
			else
			{
				$auth["enterprise"] = false;
				$auth["user"]	    = true;
			}
		}
		else
		{
			$auth["enterprise"] = false;
			$auth["user"]	    = false;
		}
		
		return $auth;
	}

	public function index()
	{
		$response = array();

		$response["Status"] = 200;
		
		$response["Auth"] = PublicController::getAuth();

		$response["Code"] = 0;
		$response["Message"] = "Everything is fine!";

		return $response;
	}

}