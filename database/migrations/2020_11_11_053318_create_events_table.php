<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('events', function (Blueprint $table) {
      $table->id();
      $table->integer('category_id')->unsigned()->index();
      $table->string('title');
      $table->text('cover_image');
      $table->text('description');
      $table->longText('content');
      $table->date('begin_date');
      $table->date('end_date');
      $table->time('begin_time');
      $table->time('end_time');
      $table->boolean('published')->default(1);
      $table->boolean('pinned')->default(0);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('events');
  }
}
