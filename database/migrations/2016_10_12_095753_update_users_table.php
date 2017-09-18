<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 255);
            $table->integer('show_nsfw');
            $table->string('show_upvote', 2);
            $table->string('avatar_image', 50);
            $table->integer('gender');
            $table->string('country', 100);
            $table->integer('birthday_year');
            $table->integer('birthday_month');
            $table->integer('birthday_day');
            $table->string('description', 255);
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
            $table->dropColumn('username');
            $table->dropColumn('show_nsfw');
            $table->dropColumn('show_upvote');
            $table->dropColumn('avatar_image');
            $table->dropColumn('gender');
            $table->dropColumn('country');
            $table->dropColumn('birthday_year');
            $table->dropColumn('birthday_month');
            $table->dropColumn('birthday_day');
            $table->dropColumn('description');
        });
    }
}
