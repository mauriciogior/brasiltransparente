<?php

use Illuminate\Database\Migrations\Migration;

class CreateEnterprisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enterprises', function($table){

			$table->increments('id');
			$table->integer('common_id');
			$table->integer('federation_id');
			$table->integer('university_id');

			$table->string('cnpj');
			$table->string('phone');
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
		Schema::drop('enterprises');
	}

}