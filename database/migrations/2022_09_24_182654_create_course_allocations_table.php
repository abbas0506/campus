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
        Schema::create('course_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('slot_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id')->nullable(); //will be initialized at step 2 of course allocation
            $table->unsignedBigInteger('semester_id');  //for which course are being allocated
            $table->boolean('result_submitted')->default(0);   //by teacher
            $table->boolean('result_forwared')->default(0);   //by hod

            $table->unique(['section_id', 'course_id'], 'section_course_unique'); //disallow same course allocation twice in a section

            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')->on('slots')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_allocations');
    }
};
