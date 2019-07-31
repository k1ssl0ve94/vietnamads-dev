<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCampaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 1000);
            $table->string('prefix', 5)->nullable();
            $table->integer('number_codes')->default(0);
            $table->integer('value');
            $table->integer('used_codes');
            $table->date('from_date');
            $table->date('end_date');
            $table->tinyInteger('status');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('campaign_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 1000);
            $table->integer('campaign_id');
            $table->integer('value');
            $table->integer('valid_times');
            $table->integer('used_times');
            $table->date('from_date');
            $table->date('end_date');
            $table->tinyInteger('status');
            $table->timestamps();
        });

        Schema::create('code_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id');
            $table->integer('code_id');
            $table->integer('user_id');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });

        Schema::table('bills', function (Blueprint $table) {
           $table->integer('promotion_point')->after('point')->default(0);
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
        Schema::dropIfExists('campaign');
        Schema::dropIfExists('campaign_codes');
        Schema::dropIfExists('code_logs');
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('promotion_point');
        });
    }
}
