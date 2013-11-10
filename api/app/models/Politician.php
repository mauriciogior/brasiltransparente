<?php

class Politician extends Eloquent {

	protected $table = 'politicians';

	public $timestamps = true;
	
	public function party()
	{
		return $this->belongsTo('Party');
	}
	
	public function city()
	{
		return $this->belongsTo('City');
	}
}