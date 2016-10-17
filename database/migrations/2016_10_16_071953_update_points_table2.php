<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePointsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('points', function (Blueprint $table) {
            
            $table->unique(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('points', function (Blueprint $table) {
            
            $table->dropIndex('points_user_id_post_id_unique');
        });
    }
}
