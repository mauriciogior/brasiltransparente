<?php

use Illuminate\Database\Migrations\Migration;

class CreateNewslettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('newsletters', function($table){

			$table->increments('id');

			$table->string('email')->unique();
			$table->string('ej');
			$table->integer('references');

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
		Schema::drop('newsletters');
	}

}