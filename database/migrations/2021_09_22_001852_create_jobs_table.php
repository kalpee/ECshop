<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('ID');
            $table->string('queue')->index()->comment('キュー');
            $table->longText('payload')->comment('情報保存');
            $table->unsignedTinyInteger('attempts')->comment('attempts');
            $table->unsignedInteger('reserved_at')->nullable()->comment('reserved_at');
            $table->unsignedInteger('available_at')->comment('available_at');
            $table->unsignedInteger('created_at')->comment('作成日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
