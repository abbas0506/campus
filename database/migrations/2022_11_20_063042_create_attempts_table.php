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
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_enrollment_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedInteger('semester_no')->nullable()->default(0);

            $table->unsignedInteger('assignment')->nullable()->default(0);
            $table->unsignedInteger('presentation')->nullable()->default(0);
            $table->unsignedInteger('midterm')->nullable()->default(0);
            $table->unsignedInteger('summative')->nullable()->default(0);

            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('internal_id')->nullable();
            $table->unsignedBigInteger('hod_id')->nullable();
            $table->date('forwaded_at')->nullable();
            $table->unsignedBigInteger('kpo_id')->nullable();
            $table->unsignedBigInteger('controller_id')->nullable();
            $table->date('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('course_enrollment_id')
                ->references('id')
                ->on('course_enrollments')
                ->onDelete('cascade');

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('attempts');
    }
};
