<?php

use Illuminate\Database\Migrations\Migration;

class CreateEducationDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('education_datas', function($table)
		{
			$table->increments('id');

			$table->integer('education_id');
			$table->integer('year');
			$table->float('percentage');

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
		Schema::drop('education_datas');
	}

}