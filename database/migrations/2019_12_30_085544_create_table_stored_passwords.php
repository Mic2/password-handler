<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTableStoredPasswords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_passwords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fk_user_email', 255);
            $table->text('password_assosiation_alias');
            $table->text('username');
            $table->string('stored_password', 255);
            $table->dateTime('created_at');

            $table->foreign('fk_user_email')->references('email')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('stored_passwords', function (Blueprint $table) {
            $table->dropForeign('stored_passwords_fk_user_email_foreign');
        });

        Schema::dropIfExists('stored_passwords');
    }
}
