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
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成年月日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新年月日');
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
