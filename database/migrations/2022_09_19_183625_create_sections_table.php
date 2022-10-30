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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('semester_id');  //root
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedInteger('semester_no')->nullable()->default(1); //dynamic
            $table->unique(['name', 'semester_id', 'program_id', 'shift_id']); //composite pk
            $table->timestamps();

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onDelete('cascade');

            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts')
                ->onDelete('cascade');

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
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
        Schema::dropIfExists('sections');
    }
};
