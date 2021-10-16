<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('owner_id')
            ->constrained()
            ->onUpdata('cascade')
            ->onDelete('cascade')->comment('オーナーIDに紐づけ');
            $table->string('name')->comment('店舗名');
            $table->text('information')->comment('説明文');
            $table->string('filename')->comment('画像ファイル名');
            $table->boolean('is_selling')->comment('販売/停止');
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
        Schema::dropIfExists('shops');
    }
}
