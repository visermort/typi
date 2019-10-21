<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable(true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('provider');
            $table->string('provider_user_id');
            $table->string('nickname')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('name')->nullable(true);
            $table->string('avatar')->nullable(true);
            $table->timestamp('email_verified_at')->nullable(true);
            $table->string('email_verify_token')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_social_accounts');
    }
}
