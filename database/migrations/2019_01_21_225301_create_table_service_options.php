<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableServiceOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191)->unique();
            $table->char('title_color', 50);
            $table->char('parameter_color', 50);
            $table->char('price_color', 50);
            $table->double('fee_point')->default(0);
            $table->string('icon')->nullable();
            $table->integer('min_days');
            $table->integer('images_number');
            $table->integer('max_content');
            $table->integer('max_title');
            $table->integer('allow_sms')->default(1);
            $table->tinyInteger('allow_promotion')->default(0);
            $table->tinyInteger('allow_management')->default(0);
            $table->tinyInteger('allow_send_author')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('day_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->integer('days');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('service_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id');
            $table->integer('option_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('type'); // PAY - REFUND (view of user)
            $table->integer('mode'); // Active - Extend
            $table->date('date');
            $table->integer('product_id');
            $table->integer('service_id');
            $table->integer('option_id');
            $table->double('point')->default(0);
            $table->double('discount')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('service_options');
        Schema::dropIfExists('day_options');
        Schema::dropIfExists('services');
        Schema::dropIfExists('bills');
    }
}
