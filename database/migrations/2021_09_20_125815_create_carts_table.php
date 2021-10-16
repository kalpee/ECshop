<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('user_id')
            ->constrained()
            ->onUpdata('cascade')
            ->onDelete('cascade')->comment('ユーザーIDと紐付け');
            $table->foreignId('product_id')
            ->constrained()
            ->onUpdata('cascade')
            ->onDelete('cascade')->comment('オーナーIDと紐付け');
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
        Schema::dropIfExists('carts');
    }
}
