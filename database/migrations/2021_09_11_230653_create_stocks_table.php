<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_stocks', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('product_id')
            ->constrained()
            ->onUpdata('cascade')
            ->onDelete('cascade')->comment('プロダクトID紐付け');
            $table->tinyInteger('type')->comment('入庫出庫');
            $table->integer('quantity')->comment('数量');
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
        Schema::dropIfExists('t_stocks');
    }
}
