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
            $table->unsignedInteger('semester_no');
            $table->unsignedBigInteger('scheme_detail_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id')->nullable(); //will be initialized at step 2 of course allocation
            $table->unsignedBigInteger('semester_id');
            $table->timestamps();

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
                ->on('users')
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
        Schema::dropIfExists('course_allocations');
    }
};
