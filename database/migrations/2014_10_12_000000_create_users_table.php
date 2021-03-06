<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('prefixname')->nullable()->index();
            $table->string('firstname')->index();
            $table->string('middlename')->nullable()->index();
            $table->string('lastname')->index();
            $table->string('suffixname')->nullable()->index();
            $table->string('username')->index();
            $table->text('photo')->nullable();
            $table->string('email')->unique();
            $table->string('type')->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->softDeletes();
            
            $table->rememberToken();
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
        $table->dropSoftDeletes();
        Schema::dropIfExists('users');
    }
}
