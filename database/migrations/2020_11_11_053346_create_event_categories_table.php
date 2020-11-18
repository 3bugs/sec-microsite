<?php

use App\Models\EventCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('event_categories', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->boolean('published')->default(1);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
    });

    $category = new EventCategory;
    $category->title = 'Seminar';
    $category->description = 'Seminar';
    $category->save();

    $category = new EventCategory;
    $category->title = 'Webinar';
    $category->description = 'Webinar';
    $category->save();

    $category = new EventCategory;
    $category->title = 'Business Matching';
    $category->description = 'Business Matching';
    $category->save();

    $category = new EventCategory;
    $category->title = 'อื่นๆ';
    $category->description = 'อื่นๆ';
    $category->save();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('event_categories');
  }
}
