<?php

use Illuminate\Database\Migrations\Migration;

class CreateSecuritiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('securities', function($table)
		{
			$table->increments('id');

			$table->string('name');
			$table->text('description');

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
		Schema::drop('securities');
	}

}