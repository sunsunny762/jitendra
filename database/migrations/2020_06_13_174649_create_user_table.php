<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('user_type_id')->unsigned()->default(2);
                $table->char('first_name', 255);
                $table->char('last_name', 255);
                $table->char('profile_image', 255)->nullable();
                $table->char('email', 255)->unique();
                $table->string('password')->nullable();;
                $table->tinyInteger('status')->default(1);
                $table->integer('created_by')->unsigned();
                $table->integer('updated_by')->unsigned();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
