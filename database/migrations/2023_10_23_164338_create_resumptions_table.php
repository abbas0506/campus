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
        Schema::create('resumptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('from_section_id'); //moved from section
            $table->unsignedBigInteger('to_section_id');    //moved to section
            $table->timestamps();
            $table->foreign('from_section_id')->references('id')->on('sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('to_section_id')->references('id')->on('sections')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resumptions');
    }
};
