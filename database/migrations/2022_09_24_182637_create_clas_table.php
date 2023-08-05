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
        Schema::create('clas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('scheme_id');    //to follow
            $table->unsignedInteger('semester_no')->default(1); //dynamic
            $table->unsignedBigInteger('first_semester_id');
            $table->unsignedBigInteger('last_semester_id')->nullable();
            $table->unique(['program_id', 'shift_id', 'first_semester_id', 'semester_no'], 'program_shift_semester_unique'); //composite pk

            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('first_semester_id')->references('id')->on('semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('last_semester_id')->references('id')->on('semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('scheme_id')->references('id')->on('schemes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clas');
    }
};
