<?php

use App\Models\Fundraising;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//https://stackoverflow.com/questions/18067614/how-can-i-set-the-default-value-of-a-timestamp-column-to-the-current-timestamp-w

class CreateFundraisingCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('fundraising_categories', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      //$table->timestamps();
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
    Schema::dropIfExists('fundraising_categorys');
  }
}
