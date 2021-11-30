<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSoftDeletesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes()->comment('論理削除');
            $table->dropUnique('users_email_unique')->comment('ユニークキー削除');
            $table->unique(['email','deleted_at'],'users_email_unique')->comment('複合ユニーク制約');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at')->comment('削除日時カラム削除');
            $table->dropUnique('users_email_unique')->comment('ユニークーキー削除');
            $table->unique('email','users_email_unique')->comment('複合ユニーク制約');
        });
    }
}
