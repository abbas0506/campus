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
            $table->unsignedBigInteger('course_id');

            $table->timestamps();
            $table->foreign('scheme_id')
                ->references('id')
                ->on('schemes')
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
