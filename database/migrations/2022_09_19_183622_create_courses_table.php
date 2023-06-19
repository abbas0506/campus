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
            $table->string('code')->unique()->nullable();
            $table->unsignedBigInteger('course_type_id')->default(1);
            $table->unsignedInteger('credit_hrs_theory');
            $table->unsignedInteger('max_marks_theory');
            $table->unsignedInteger('credit_hrs_practical');
            $table->unsignedInteger('max_marks_practical');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('course_type_id')
                ->references('id')
                ->on('course_types')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('courses');
    }
};
