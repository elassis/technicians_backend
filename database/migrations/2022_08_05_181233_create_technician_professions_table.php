<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicianProfessionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('technician_professions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('technician_id');
      $table->unsignedBigInteger('profession_id');
      $table->integer('price_hour')->default(0);
      $table->timestamps();

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
    Schema::dropIfExists('technician_professions');
  }
}
