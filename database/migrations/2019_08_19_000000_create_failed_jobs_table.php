<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('uuid')->unique()->comment('UUID');
            $table->text('connection')->comment('接続状況');
            $table->text('queue')->comment('キュー');
            $table->longText('payload')->comment('情報保存');
            $table->longText('exception')->comment('有効期限');
            $table->timestamp('failed_at')->useCurrent()->comment('ジョブ失敗時間');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
