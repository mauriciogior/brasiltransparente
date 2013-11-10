<?php

class EducationController extends BaseController {

	public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Education";
		$response["Message"] 	= "All years data.";

		$educations = Education::all();

		foreach($educations as $education)
			$education->data->toArray();

		$response["Data"] = $educations->toArray();

		return $response;
	}

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Education";

		if($id == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"] = 0;

		$education = Education::find($id);

		if($education == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$education->data->toArray();

		$response["Data"] = $education->toArray();

		return $response;
	}

	public function index()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Code"]		= 0;
		$response["From"]		= "Education";
		$response["Message"] 	= "Everything is fine!";

		return $response;
	}

	public function create()
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'name' => array('required'),
			'city_id' => array('required'),
			'description' => array('required'),
		));

		if(!$validation->fails())
		{
			$education = new Education;

			$education->name = Input::get('name');
			$education->city_id = Input::get('city_id');
			$education->description = Input::get('description');

			$education->save();

			$response["Code"]	 = 0;
			$response["From"]	 = "Education";
			$response["Message"] = "Data #".$education->id." registered!";
			$response["Data"] 	 = $education->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Education";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}

	public function attach()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["From"]		= "Education";

		$validation = Validator::make(Input::all(), array(
			'education_id' => array('required'),
			'year' => array('required'),
			'percentage' => array('required'),
		));

		if(!$validation->fails())
		{
			$education = Education::find(Input::get('education_id'));

			if($education == null)
			{
				$response["Code"]		= 2;
				$response["Message"] 	= "Sorry, couldn't find this ID.";

				return $response;
			}

			$educationData = new EducationData;

			$educationData->education_id = Input::get('education_id');
			$educationData->year = Input::get('year');
			$educationData->percentage = Input::get('percentage');

			$education->data()->save($educationData);

			$education->data->toArray();

			$response["Code"]		 = 0;
			$response["From"]		 = "Education";
			$response["Message"]	 = "Data attached!";
			$response["Data"] 		 = $education->toArray();
		
			return $response;
		}
		else
		{
			$response["From"]	 = "Education";
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}
}