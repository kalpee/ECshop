<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('商品名');
            $table->text('information')->comment('説明文');
            $table->unsignedInteger('price')->comment('価格');
            $table->boolean('is_selling')->comment('販売/停止');
            $table->integer('sort_order')->nullable()->comment('並び順');
            $table->foreignId('shop_id')
            ->constrained()
            ->onUpdata('cascade')
            ->onDelete('cascade')->comment('ショップIDに紐づけ');
            $table->foreignId('secondary_category_id')
            ->constrained()->comment('セカンダリーカテゴリーIDに紐付け');
            $table->foreignId('image1')
            ->nullable()
            ->constrained('images')->comment('画像紐付け（null可）');
            $table->foreignId('image2')
            ->nullable()
            ->constrained('images')->comment('画像紐付け（null可）');
            $table->foreignId('image3')
            ->nullable()
            ->constrained('images')->comment('画像紐付け（null可）');
            $table->foreignId('image4')
            ->nullable()
            ->constrained('images')->comment('画像紐付け（null可）');
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
        Schema::dropIfExists('products');
    }
}
