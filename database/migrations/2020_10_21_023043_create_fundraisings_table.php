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
      $table->integer('fundraising_category_id')->unsigned()->index();
      $table->string('title');
      $table->text('cover_image');
      $table->text('description');
      $table->longText('content');
      $table->timestamps();
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
