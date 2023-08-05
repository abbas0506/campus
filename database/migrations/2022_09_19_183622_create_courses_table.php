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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short');
            $table->string('code', 20)->nullable();
            $table->unsignedInteger('cr_theory');
            $table->unsignedInteger('cr_practical');
            $table->unsignedInteger('marks_theory');
            $table->unsignedInteger('marks_practical');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('course_type_id')->default(1);
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('course_type_id')->references('id')->on('course_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
