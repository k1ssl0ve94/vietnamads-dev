<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBill0127 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bills', function (Blueprint $table) {
            $table->date('from');
            $table->date('to');
            $table->integer('active_days')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('package_option')->nullable()->after('level');
            $table->char('title_color', 50)->nullable();
            $table->char('parameter_color', 50)->nullable();
            $table->char('price_color', 50)->nullable();
            $table->string('icon')->nullable();

            $table->integer('images_number')->default(1);
            $table->integer('allow_sms')->default(1);
            $table->tinyInteger('allow_promotion')->default(0);
            $table->tinyInteger('allow_management')->default(0);
            $table->tinyInteger('allow_send_author')->default(0);
            $table->integer('manual_refresh')->default(0);
            $table->integer('auto_refresh')->default(0);
            $table->integer('refresh_fee')->default(0);

            $table->integer('backup_time')->default(0);
            $table->integer('direct_link')->default(0);
            $table->integer('priority')->default(1);
            $table->integer('display_in_trend')->default(0);
            $table->integer('display_in_search')->default(0);
            $table->integer('display_in_tags')->default(0);
            $table->tinyInteger('auto_active')->default(0);
            $table->integer('edit_times')->default(0);
            $table->tinyInteger('keep_alive')->default(0);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('remain_point')->default(0)->after('used_point');
            $table->integer('promotion_point')->default(0)->after('used_point');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remain_point');
            $table->dropColumn('promotion_point');
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('from_date');
            $table->dropColumn('to_date');
            $table->dropColumn('active_days');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('package_option');
        });
    }
}
