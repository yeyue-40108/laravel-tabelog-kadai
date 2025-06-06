<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('furigana')->after('name')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->string('work')->nullable();

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
            $table->dropColumn('furigana');
            $table->dropColumn('phone');
            $table->dropColumn('birthday');
            $table->dropColumn('work');
        });
    }
};
