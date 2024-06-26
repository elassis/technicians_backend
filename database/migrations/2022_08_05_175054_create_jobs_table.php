<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('jobs', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('technician_id');
      $table->unsignedBigInteger('profession_id');
      $table->unsignedBigInteger('user_id');
      $table->string('status')->default('pending');
      $table->string('text', 250);
      $table->string('comments')->nullable();
      $table->timestamp('begin_date')->nullable();
      $table->timestamp('end_date')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('technician_id')->references('id')->on('technicians')
        ->onDelete('cascade');
      $table->foreign('profession_id')->references('id')->on('professions');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('jobs');
  }
}
