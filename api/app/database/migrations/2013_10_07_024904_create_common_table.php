<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('common', function($table){

			$table->increments('id');

			$table->integer('language_id');

			$table->string('name');
			$table->string('email');
			$table->string('address');
			$table->string('city');
			$table->string('state');
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
		Schema::drop('common');
	}

}