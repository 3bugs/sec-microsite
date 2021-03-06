<?php

use App\Models\FundraisingCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundraisingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('fundraisings', function (Blueprint $table) {
      $table->id();
      $table->integer('category_id')->unsigned()->index();
      $table->string('title');
      $table->text('cover_image');
      $table->text('description');
      $table->longText('content');
      $table->boolean('published')->default(1);
      $table->boolean('pinned')->default(0);
      $table->integer('sort_index')->default(0);
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
    Schema::dropIfExists('fundraisings');
  }
}
