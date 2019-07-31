<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostSeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('posts', function(Blueprint $table){
            $table->string('image_alt', 1000)->nullable();
            $table->string('meta_title', 1000)->nullable();
            $table->string('meta_description', 1000)->nullable();
            $table->string('meta_keywords', 1000)->nullable();
            $table->string('meta_canonical', 1000)->nullable();
            $table->string('slug', 1000)->nullable();
        });
        Schema::table('class_categories', function (Blueprint $table){
            $table->text('description')->nullable();
            $table->string('meta_title', 1000)->nullable();
            $table->string('meta_description', 1000)->nullable();
            $table->string('meta_keywords', 1000)->nullable();
            $table->string('meta_canonical', 1000)->nullable();
        });
        Schema::table('categories', function (Blueprint $table){
            $table->string('meta_title', 1000)->nullable();
            $table->string('meta_description', 1000)->nullable();
            $table->string('meta_keywords', 1000)->nullable();
            $table->string('meta_canonical', 1000)->nullable();
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
        Schema::table('posts', function(Blueprint $table){
            $table->dropColumn('image_alt');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_canonical');
            $table->dropColumn('slug');
        });
        Schema::table('class_categories', function (Blueprint $table){
            $table->dropColumn('description');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_canonical');
        });
        Schema::table('categories', function (Blueprint $table){
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
            $table->dropColumn('meta_canonical');
        });
    }
}
