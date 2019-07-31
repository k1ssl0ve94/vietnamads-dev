<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterService0125 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('level')->nullable();
            $table->date('level_apply_date')->nullable();
            $table->date('level_end_date')->nullable();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->integer('refresh_fee')->nullable()->after('auto_refresh');
            $table->tinyInteger('auto_active')->default(0);
            $table->integer('edit_times')->default(0);
            $table->tinyInteger('keep_alive')->default(0);
            $table->tinyInteger('vip_only')->default(0);
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
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('refresh_fee');
            $table->dropColumn('auto_active');
            $table->dropColumn('edit_times');
            $table->dropColumn('keep_alive');
            $table->dropColumn('vip_only');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropColumn('level_apply_date');
            $table->dropColumn('level_end_date');
        });
    }
}
