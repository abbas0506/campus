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
        Schema::create('scheme_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheme_id');
            $table->unsignedInteger('semester_no');
            $table->unsignedInteger('slot');
            $table->unsignedBigInteger('course_id');

            $table->unique(['scheme_id', 'course_id'], 'scheme_course_unique');

            $table->timestamps();
            $table->foreign('scheme_id')
                ->references('id')
                ->on('schemes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
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
        Schema::dropIfExists('scheme_details');
    }
};
