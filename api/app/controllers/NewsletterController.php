<?php

class NewsletterController extends BaseController {

	/*public function all()
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"] 		= PublicController::getAuth();
		$response["Code"]		= 0;
		$response["Message"] 	= "List of people registered for newsletter.";

		$newsletters = Newsletter::all();

		$response["Newsletters"] = $newsletters->toArray();

		return $response;
	}*/

	public function info($id = null)
	{
		$response = array();

		$response["Status"] 	= 200;
		$response["Auth"] 		= PublicController::getAuth();

		if($id == null)
		{
			$response["Code"]		= 2;
			$response["Message"] 	= "Please give me an ID.";

			return $response;
		}

		$response["Code"]		= 0;

		$newsletter = Newsletter::find($id);

		if($newsletter == null)
		{
			$response["Code"]		= 1;
			$response["Message"] 	= "Sorry, couldn't find this ID.";

			return $response;
		}

		$newsletter->reference_id = base64_encode($newsletter->id);
		$newsletter->email = "secret";

		$response["Data"] = $newsletter->toArray();

		return $response;
	}

	public function create($ref = null)
	{
		$response = array();

		$response["Status"] = 200;

		$validation = Validator::make(Input::all(), array(
			'email' => array('required'),
			'ej' => array('required')
		));

		if(!$validation->fails())
		{
			$newsletter_check = Newsletter::where('email','=',Input::get('email'))->get()->toArray();

			if(!empty($newsletter_check))
			{
				$response["Auth"] 	 = PublicController::getAuth();
				$response["Code"]	 = 2;
				$response["Message"] = "Person already registered for newsletter...";
				
				return $response;
			}

			if($ref != null)
			{
				$ref = base64_decode($ref);

				$referencied_by	= Newsletter::where('id','=',$ref)->first();

				if($referencied_by == null)
				{
					$response["Auth"] 	 = PublicController::getAuth();
					$response["Code"]	 = 3;
					$response["Message"] = "This reference does not exist!";
					$response["Data"] 	 = null;
				
					return $response;
				}

				$referencied_by->references++;

				$referencied_by->save();
			}

			$newsletter = new Newsletter;

			$newsletter->email = Input::get('email');
			$newsletter->ej = Input::get('ej');

			$newsletter->save();

			$newsletter->reference_id = base64_encode($newsletter->id);

			$response["Auth"] 	 = PublicController::getAuth();
			$response["Code"]	 = 0;
			$response["Message"] = "Person registered for newsletter!";
			$response["Data"] 	 = $newsletter->toArray();
		
			return $response;
		}
		else
		{
			$response["Auth"] 	 = PublicController::getAuth();
			$response["Code"]	 = 1;
			$response["Message"] = $validation->messages()->all();
			
			return $response;
		}
	}
}