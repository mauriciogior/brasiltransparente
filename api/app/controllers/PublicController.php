<?php

class PublicController extends BaseController {

	public function index()
	{
		$response = array();

		$response["Status"] = 200;
		$response["Code"] = 0;
		$response["Message"] = "Everything is fine!";

		return $response;
	}

}