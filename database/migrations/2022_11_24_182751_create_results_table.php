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
            $table->unsignedBigInteger('course_track_id');
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
            $table->date('approved_at')->nullable(); //make null to allow editing

            $table->unique(['course_track_id', 'semester_id']);
            $table->foreign('course_track_id')
                ->references('id')
                ->on('course_tracks')
                ->onDelete('cascade');

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
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
        Schema::dropIfExists('results');
    }
};
