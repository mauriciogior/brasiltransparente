<?php

class PartyController extends BaseController {

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Party";
		$response["Message"] 	= "All parties.";

		$parties = Party::all();

		foreach($parties as $party)
			$party->politician->toArray();

		$response["Data"] = $parties->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Party";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$party = Party::find($id);

		if($party == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$party->politician->toArray();

		$response["Data"] = $party->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Party";
		$response["Message"] 	= "Everything is fine!";

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'name' => array('required'),
			'flag' => array('required'),
		));

		if(!$validation->fails())
		{
			$party = new Party;

			$party->name = Input::get('name');
			$party->flag = Input::get('flag');

			$party->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "Party";
			$response["Message"] = "Data #".$party->id." registered!";

			$party->politician->toArray();

			$response["Data"] 	 = $party->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Party";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

}