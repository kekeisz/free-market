<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionIdToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            // ① まず nullable でカラム追加
            $table->unsignedBigInteger('condition_id')
                ->nullable()
                ->after('status');

            // ② その上で外部キーを張る（NULL は許可される）
            $table->foreign('condition_id')
                ->references('id')
                ->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('condition_id');
            $table->dropColumn('condition_id');
        });
    }
}
