<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('banners', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('image');
      $table->text('url');
      $table->boolean('published')->default(1);
      $table->integer('sort_index')->default(0);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('banners');
  }
}
