<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('email', 50)->unique();
            $table->string('password')->nullable();
            $table->string('department_id')->nullable();
            $table->boolean('owner')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
