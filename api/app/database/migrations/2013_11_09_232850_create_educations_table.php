<?php

use Illuminate\Database\Migrations\Migration;

class CreateEducationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('educations', function($table)
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
		Schema::drop('educations');
	}

}