<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('title')->nullable();
            $table->integer('city')->nullable();
            $table->integer('district')->nullable();
            $table->integer('ward')->nullable();
            $table->integer('street')->nullable();
            $table->text('content')->nullable();
            $table->integer('category')->nullable();
            $table->tinyInteger('category_parent')->nullable();
            $table->tinyInteger('status')->default(0); // pending, active, inactive
            $table->tinyInteger('level')->default(0); // 1: normal, 2: vip
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_address')->nullable();
            $table->text('keywords')->nullable();
            $table->text('images')->nullable();
            $table->datetime('from')->nullable();
            $table->datetime('to')->nullable();
            $table->string('link')->nullable();
            $table->decimal('price', 60, 3)->default(0);
            $table->string('price_unit')->nullable();
            $table->integer('provider')->nullable();
            $table->string('currency')->default('VND');

            // pano
            $table->integer('pano_type')->nullable(); // loai bien
            $table->integer('pano_size')->nullable(); // kich thuoc pano
            $table->integer('pano_border')->nullable(); // khung
            $table->integer('pano_light')->nullable(); // đèn điện

            // ad
            $table->integer('ad_channel')->nullable(); // loai kenh
            $table->integer('ad_coverage')->nullable(); // do phu song
            $table->integer('ad_time')->nullable(); // thoi luong

            // social
            $table->integer('social_type')->nullable(); // loai quang cao
            $table->integer('social_follow')->nullable(); // luong theo doi

            // web
            $table->integer('web_type')->nullable(); // loai trang
            $table->integer('web_position')->nullable(); // trang xuat hien

            $table->softDeletes();
            $table->timestamps();

            $table->index('title');
            $table->index('price');
            $table->index('user_id');
            $table->index('from');
            $table->index('to');
            $table->index('category');
            $table->index('category_parent');
            $table->index('level');
            $table->index('pano_type');
            $table->index('pano_size');
            $table->index('pano_border');
            $table->index('pano_light');
            $table->index('ad_channel');
            $table->index('ad_coverage');
            $table->index('ad_time');
            $table->index('social_type');
            $table->index('social_follow');
            $table->index('web_type');
            $table->index('web_position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
