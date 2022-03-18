<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_points', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mac_address');
            $table->string('product');
            $table->unsignedBigInteger('tower_id');
            $table->string('type');
            $table->timestamps();
            $table->foreign('tower_id')->references('id')->on('towers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_points');
    }
}
