<?php

class Education extends Eloquent {

	protected $table = 'educations';

	public $timestamps = true;

	public function data()
	{
		return $this->hasMany('EducationData');
	}
}