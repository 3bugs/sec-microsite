<?php

use App\Models\MediaCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media_categories', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->boolean('published')->default(1);
      $table->integer('sort_index')->default(0);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
    });

    $category = new MediaCategory;
    $category->title = 'บทความที่เกี่ยวข้อง';
    $category->description = 'บทความที่เกี่ยวข้อง';
    $category->save();

    $category = new MediaCategory;
    $category->title = 'Link อื่นๆ ที่เกี่ยวข้อง';
    $category->description = 'Link อื่นๆ ที่เกี่ยวข้อง';
    $category->save();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('media_categories');
  }
}
