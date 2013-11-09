<?php

class Enterprise extends Eloquent {

	protected $table = 'enterprises';

	public function common()
	{
		return $this->belongsTo('Common');
	}

	public function federation()
	{
		return $this->belongsTo('Federation');
	}

	public function university()
	{
		return $this->belongsTo('University');
	}
}