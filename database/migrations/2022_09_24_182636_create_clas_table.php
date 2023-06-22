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
            $table->unsignedBigInteger('semester_id');  //root
            $table->unsignedBigInteger('scheme_id');    //to follow
            $table->unsignedInteger('semester_no')->default(1); //dynamic
            $table->boolean('status')->default(1);  //finished:0, active:1 
            $table->unique(['program_id', 'shift_id', 'semester_id'], 'program_shift_semester_unique'); //composite pk

            $table->timestamps();

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('scheme_id')
                ->references('id')
                ->on('schemes')
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
        Schema::dropIfExists('clas');
    }
};
