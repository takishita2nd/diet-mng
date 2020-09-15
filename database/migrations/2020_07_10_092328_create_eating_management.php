<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEatingManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eating_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->text('item');
            $table->double('protein');
            $table->double('liqid');
            $table->double('carbo');
            $table->double('calorie');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        Schema::create('eating_management_user', function (Blueprint $table) {
            $table->integer('user_id')
                  ->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->integer('eating_management_id')
                  ->foreign('eating_management_id')
                  ->references('id')->on('eating_managements')
                  ->onDelete('cascade');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        Schema::create('timezones', function (Blueprint $table) {
            $table->increments('id');
            $table->text('zone');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        Schema::create('eating_management_timezone', function (Blueprint $table) {
            $table->integer('eating_management_id')
                  ->foreign('eating_management_id')
                  ->references('id')->on('eating_managements')
                  ->onDelete('cascade');
            $table->integer('timezone_id')
                  ->foreign('timezone_id')
                  ->references('id')->on('timezones')
                  ->onDelete('cascade');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eating_management_timezone');
        Schema::dropIfExists('timezones');
        Schema::dropIfExists('eating_management_user');
        Schema::dropIfExists('eating_managements');
    }
}
