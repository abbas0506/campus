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
            $table->unsignedBigInteger('semester_id');
            $table->enum('shift', ['M', 'E']);
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('scheme_detail_id');
            $table->unsignedBigInteger('instructor_id')->nullable();

            $table->timestamps();

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

            $table->foreign('instructor_id')
                ->references('id')
                ->on('employees')
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
