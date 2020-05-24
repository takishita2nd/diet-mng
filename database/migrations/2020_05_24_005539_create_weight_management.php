<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeightManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datetime');
            $table->decimal('weight', 5, 2);
            $table->decimal('fat_rate', 5, 2);
            $table->decimal('bmi', 5, 2);
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });

        Schema::create('users_weight_managements', function (Blueprint $table) {
            $table->integer('users_id')
                  ->foreign('users_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->integer('weight_managements_id')
                  ->foreign('weight_managements_id')
                  ->references('id')->on('weight_managements')
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
        //
    }
}
