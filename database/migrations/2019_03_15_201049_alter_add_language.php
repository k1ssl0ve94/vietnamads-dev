<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 0: vi
        // 1: en
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('lang')->default(0);
            $table->index('lang');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->tinyInteger('lang')->default(0);
            $table->index('lang');
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
    }
}
