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

            $table->unsignedInteger('semester_no');
            $table->unsignedInteger('assignment')->nullable()->default(0);
            $table->unsignedInteger('presentation')->nullable()->default(0);
            $table->unsignedInteger('midterm')->nullable()->default(0);
            $table->unsignedInteger('summative')->nullable()->default(0);
            $table->boolean('editable')->default(1);    //before final submission will be editable, or may be unlocked by hod personally

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('course_allocation_id');

            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->unsignedBigInteger('submitter_id')->nullable();
            $table->unsignedBigInteger('verifier_id')->nullable();
            $table->unsignedBigInteger('approver_id')->nullable();

            //disallow re-registration  of same student for a specific course within same semester
            $table->unique(['student_id', 'semester_id', 'course_allocation_id'], 'student_semester_allocation_unique');

            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('course_allocation_id')->references('id')->on('course_allocations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('submitter_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('verifier_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

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
