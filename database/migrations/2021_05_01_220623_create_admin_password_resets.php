<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPasswordResets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_password_resets', function (Blueprint $table) {
            $table->string('email')->index()->comment('メール');
            $table->string('token')->comment('トークン');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_password_resets');
    }
}
