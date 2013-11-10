<?php

class Politician extends Eloquent {

	protected $table = 'politicians';

	public $timestamps = true;
	
	public function data()
	{
		return $this->belongsTo('Party');
	}
}