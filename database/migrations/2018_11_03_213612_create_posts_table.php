<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('sapo')->nullable();
            $table->string('image')->nullable();
            $table->longText('content')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->datetime('publish_at')->nullable();
            $table->tinyInteger('cat')->default(0);
            $table->tinyInteger('hot')->default(0);
            $table->timestamps();

            $table->index('title');
            $table->index('user_id');
            $table->index('status');
            $table->index('cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
