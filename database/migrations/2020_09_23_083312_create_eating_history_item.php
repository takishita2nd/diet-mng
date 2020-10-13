<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEatingHistoryItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eating_history_items', function (Blueprint $table) {
            $table->bigIncrements('id');
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

        Schema::create('eating_history_item_user', function (Blueprint $table) {
            $table->integer('user_id')
                  ->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->integer('eating_history_item_id')
                  ->foreign('eating_history_item_id')
                  ->references('id')->on('eating_history_items')
                  ->onDelete('cascade');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        Schema::create('eating_template_items', function (Blueprint $table) {
            $table->bigIncrements('id');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eating_template_items');
        Schema::dropIfExists('eating_history_item_user');
        Schema::dropIfExists('eating_history_items');
    }
}
