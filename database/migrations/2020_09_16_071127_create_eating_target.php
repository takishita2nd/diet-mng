<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEatingTarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eating_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('protein');
            $table->double('liqid');
            $table->double('carbo');
            $table->double('calorie');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        Schema::create('eating_target_user', function (Blueprint $table) {
            $table->integer('user_id')
                  ->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->integer('eating_target_id')
                  ->foreign('eating_target_id')
                  ->references('id')->on('eating_targets')
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
        Schema::dropIfExists('eating_target_user');
        Schema::dropIfExists('eating_targets');
    }
}
