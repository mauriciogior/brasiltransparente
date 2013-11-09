<?php

use Illuminate\Database\Migrations\Migration;

class CreateFederationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('federations', function($table){

			$table->increments('id');

			$table->string('cnpj');
			$table->string('acronym');
			$table->string('name');
			$table->string('state');
			$table->string('country');
			$table->string('website');

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
		Schema::drop('federations');
	}

}