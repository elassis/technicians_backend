<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('technician_id');
          $table->unsignedBigInteger('job_id');
          $table->bigInteger('job_ranking');
          $table->timestamps();

          $table->foreign('job_id')->references('id')->on('jobs')
          ->onDelete('cascade');
          $table->foreign('technician_id')->references('id')->on('technicians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rankings');
    }
}
