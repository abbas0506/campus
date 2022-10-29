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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('shift_id');
            $table->string('section', 1);
            $table->unsignedBigInteger('course_id');
            $table->boolean('is_reappear');

            $table->unsignedInteger('assignment');
            $table->unsignedInteger('presentation');
            $table->unsignedInteger('midterm');
            $table->unsignedInteger('summative');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('internal_id');
            $table->unsignedBigInteger('hod_id');
            $table->date('forwaded_at');
            $table->unsignedBigInteger('kpo_id');
            $table->unsignedBigInteger('controller_id');
            $table->date('approved_at');
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
        Schema::dropIfExists('results');
    }
};
