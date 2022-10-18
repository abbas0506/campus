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
        Schema::create('elective_course_allocations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('scheme_detail_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onDelete('cascade');

            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');

            $table->foreign('scheme_detail_id')
                ->references('id')
                ->on('scheme_details')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');

            $table->foreign('teacher_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade');

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
        Schema::dropIfExists('elective_course_allocations');
    }
};
