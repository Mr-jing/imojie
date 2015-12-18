<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->index();
            $table->string('oauth_id');
            $table->string('oauth_type');
            $table->unique(['oauth_id', 'oauth_type']);
            $table->timestamp('created_at');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth_accounts');
    }
}
