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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester_type_id');
            $table->unsignedInteger('year');
            $table->boolean('status')->default(0);
            $table->date('ends_at')->nullable(); //last date of result submission

            $table->timestamps();
            $table->unique(['semester_type_id', 'year']);
            $table->foreign('semester_type_id')->references('id')->on('semester_types')->onDelete('cascade');  //cascade delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semesters');
    }
};
