<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('phone_number', 20)->default('');
            $table->tinyInteger('gender')->default(0);
            $table->char('register_ip', 40)->default('');
            $table->bigInteger('birthday')->default(0);
            $table->tinyInteger('zodiac')->default(0);
            $table->tinyInteger('constellation')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
