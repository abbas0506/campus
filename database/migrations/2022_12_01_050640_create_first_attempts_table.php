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
        Schema::create('first_attempts', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('semester_no');

            $table->unsignedInteger('assignment')->nullable()->default(0);
            $table->unsignedInteger('presentation')->nullable()->default(0);
            $table->unsignedInteger('midterm')->nullable()->default(0);
            $table->unsignedInteger('summative')->nullable()->default(0);

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('course_allocation_id');
            //disallow re-registration  of same student for a specific course within same semester
            $table->unique(['student_id', 'semester_id', 'course_allocation_id'], 'student_semester_allocation_unique');

            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_allocation_id')->references('id')->on('course_allocations')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('first_attempts');
    }
};
