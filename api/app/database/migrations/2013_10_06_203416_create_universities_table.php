<?php

use Illuminate\Database\Migrations\Migration;

class CreateUniversitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('universities', function($table){

			$table->increments('id');

			$table->string('acronym');
			$table->string('name');
			$table->string('type');
			$table->string('country');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('universities');
	}

}