<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_id');
            $table->unsignedBigInteger('course_type_id');
            $table->unsignedBigInteger('course_id')->nullable();

            $table->timestamps();

            $table->foreign('slot_id')
                ->references('id')
                ->on('slots')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('course_type_id')
                ->references('id')
                ->on('course_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
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
        Schema::dropIfExists('slot_options');
    }
};
