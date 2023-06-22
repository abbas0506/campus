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
        Schema::create('reappears', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('first_attempt_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedInteger('semester_no');

            $table->unsignedInteger('assignment')->nullable()->default(0);
            $table->unsignedInteger('presentation')->nullable()->default(0);
            $table->unsignedInteger('midterm')->nullable()->default(0);
            $table->unsignedInteger('summative')->nullable()->default(0);

            $table->unsignedBigInteger('course_allocation_id');
            $table->unique(['first_attempt_id', 'semester_id'], 'first_attempt_semester_unique');

            $table->foreign('first_attempt_id')
                ->references('id')
                ->on('first_attempts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('course_allocation_id')
                ->references('id')
                ->on('course_allocations')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('reappears');
    }
};
