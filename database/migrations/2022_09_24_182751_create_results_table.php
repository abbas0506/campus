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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_allocation_id');
            $table->boolean('is_reappear')->default(0);
            $table->unsignedInteger('assignment')->nullable()->default(0);
            $table->unsignedInteger('presentation')->nullable()->default(0);
            $table->unsignedInteger('midterm')->nullable()->default(0);
            $table->unsignedInteger('summative')->nullable()->default(0);

            $table->unsignedBigInteger('internal_id')->nullable();
            $table->unsignedBigInteger('hod_id')->nullable();
            $table->date('forwaded_at')->nullable();
            $table->unsignedBigInteger('kpo_id')->nullable();
            $table->unsignedBigInteger('controller_id')->nullable();
            $table->date('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('course_allocation_id')
                ->references('id')
                ->on('course_allocations')
                ->onDelete('cascade');

            $table->foreign('hod_id')
                ->references('id')
                ->on('teachers')
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
        Schema::dropIfExists('results');
    }
};
