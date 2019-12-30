<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('stored_password', 255);

            $table->foreign('fk_user_email')->references('email')->on('users');

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
