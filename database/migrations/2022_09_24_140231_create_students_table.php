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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('father', 100)->nullable();
            $table->string('cnic', 15)->nullable()->unique();
            $table->string('phone', 12)->nullable();
            $table->string('email', 12)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('pic', 100)->default('default.png');
            $table->date('dob')->nullable();
            $table->enum('gender', ['M', 'F', 'T']);
            $table->string('regno', 20)->nullable();
            $table->string('rollno', 20);
            $table->unsignedBigInteger('section_id');


            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
