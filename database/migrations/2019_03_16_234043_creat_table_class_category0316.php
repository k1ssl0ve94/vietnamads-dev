<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatTableClassCategory0316 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('class_categories', function (Blueprint $table){
            $table->increments('id');
            $table->tinyInteger('type');
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('name', 255);
            $table->integer('total_products')->default(0);
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_mobile', 100)->nullable();
            $table->string('note', 2000)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('class_categories_products', function (Blueprint $table){
            $table->increments('id');
            $table->integer('class_category_id');
            $table->integer('product_id');
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
        //
        Schema::dropIfExists('class_categories');
        Schema::dropIfExists('class_categories_products');
    }
}
