<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->index();
            $table->string('title')->index();
            $table->text('original_content');
            $table->text('content');

            $table->integer('order')->default(0)->index();
            $table->integer('active_at')->default(0)->index();
            $table->boolean('is_excellent')->default(false)->index();
            $table->boolean('is_hide')->default(false)->index();
            $table->boolean('is_locked')->default(false);
            $table->boolean('is_draft')->default(false);

            $table->integer('view_count')->default(0);
            $table->integer('reply_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->integer('hate_count')->default(0);

            $table->softDeletes();
            $table->timestamps();

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
        Schema::drop('topics');
    }
}
