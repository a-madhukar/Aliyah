<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->string('first_name',20);
			$table->string('last_name',20);
			$table->string('address_line1',30);  
			$table->string('address_line2',30);
			$table->string('city',20);
			$table->string('state',20);
			$table->string('country',20);
			$table->integer('postcode');
			$table->string('phone',12);
			$table->string('passport_no',12);
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
		Schema::drop('profiles');
	}

}
