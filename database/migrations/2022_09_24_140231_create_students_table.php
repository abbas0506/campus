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
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('father')->nullable();
            $table->string('cnic', 15)->unique();
            $table->string('phone', 12)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('pic', 100)->default('default.png');

            $table->date('dob')->nullable();
            $table->enum('blood_group', ['A+', 'B+', 'AB+', 'O+', 'O-', 'A-', 'B-', 'AB-'])->nullable();
            $table->boolean('is_married')->nullable();
            $table->boolean('is_special')->nullable();

            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('domicile_id')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();

            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('semester_id'); //enrollment semester
            $table->unsignedBigInteger('program_id');
            $table->enum('shift', ['M', 'E'])->default('M');
            $table->string('section', 20)->nullable();
            $table->string('registration_no', 20)->nullable();
            $table->unsignedInteger('current_semester')->default(1); //current
            $table->unsignedInteger('rollno')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('gender_id')
                ->references('id')
                ->on('genders')
                ->onDelete('set null');

            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities')
                ->onDelete('set null');

            $table->foreign('domicile_id')
                ->references('id')
                ->on('domiciles')
                ->onDelete('set null');

            $table->foreign('religion_id')
                ->references('id')
                ->on('religions')
                ->onDelete('set null');

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');  //cascade delete

            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade');  //cascade delete

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
