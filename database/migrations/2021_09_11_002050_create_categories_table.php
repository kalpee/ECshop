<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_categories', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('大カテゴリー名');
            $table->integer('sort_order')->comment('並び順');
            $table->timestamps();
        });

        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('小カテゴリー名');
            $table->integer('sort_order')->comment('並び順');
            $table->foreignId('primary_category_id')
            ->constrained()->comment('大カテゴリーIDと紐付け');
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
        Schema::dropIfExists('secondary_categories');
        Schema::dropIfExists('primary_categories');
    }
}
