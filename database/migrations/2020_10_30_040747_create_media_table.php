<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media', function (Blueprint $table) {
      $table->id();
      $table->integer('category_id')->unsigned()->index();
      $table->string('title');
      $table->text('cover_image');
      $table->text('description');
      $table->longText('content');
      $table->boolean('published')->default(1);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function dophpwn()
  {
    Schema::dropIfExists('media');
  }
}
