<?php

class PoliticianController extends BaseController {

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Politician";
		$response["Message"] 	= "All politicians.";

		$politicians = Politician::all();

		foreach($politicians as $politician)
			$politician->party->toArray();

		$response["Data"] = $politicians->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Politician";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$politician = Politician::find($id);

		if($politician == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$politician->party->toArray();

		$response["Data"] = $politician->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Politician";
		$response["Message"] 	= "Everything is fine!";

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'name' => array('required'),
			'party_id' => array('required'),
			'role' => array('required'),
			'avatar' => array('required'),
		));

		if(!$validation->fails())
		{
			$politician = new Politician;

			$politician->name = Input::get('name');
			$politician->party_id = Input::get('party_id');
			$politician->role = Input::get('role');
			$politician->avatar = Input::get('avatar');

			$politician->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "Politician";
			$response["Message"] = "Data #".$politician->id." registered!";

			$politician->party->toArray();

			$response["Data"] 	 = $politician->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Politician";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

}