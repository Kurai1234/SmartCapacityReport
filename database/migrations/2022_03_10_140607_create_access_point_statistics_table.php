<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessPointStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_point_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('access_point_id');
            $table->string('mode');
            $table->double('dl_retransmit');
            $table->double('dl_retransmit_pcts');
            $table->double('dl_pkts');
            $table->double('ul_pkts');
            $table->double('dl_throughput');
            $table->double('ul_throughput');
            $table->string('status');
            $table->integer('connected_sms');
            $table->integer('reboot');
            $table->double('frame_utilization');
            $table->timestamps();
            // $table->foreign('access_point_id')->references('id')->on('access_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_point_statistics');
    }
}
