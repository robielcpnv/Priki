<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->foreign(['publication_state_id'], 'fk_practice_states1')->references(['id'])->on('publication_states')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['domain_id'], 'fk_practice_themes')->references(['id'])->on('domains')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'fk_practice_submitter')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practices', function (Blueprint $table) {
            $table->dropForeign('fk_practice_states1');
            $table->dropForeign('fk_practice_themes');
            $table->dropForeign('fk_practice_submitter');
        });
    }
}
