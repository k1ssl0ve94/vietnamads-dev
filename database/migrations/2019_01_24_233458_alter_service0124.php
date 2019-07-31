<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterService0124 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('services', function (Blueprint $table){
            $table->integer('backup_time')->default(0)->after('min_days');
            $table->integer('direct_link')->default(0)->after('min_days');
            $table->integer('priority')->default(1)->after('min_days');
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
        Schema::table('services', function (Blueprint $table){
            $table->dropColumn('backup_time');
            $table->dropColumn('direct_link');
            $table->dropColumn('priority');
        });
    }
}
