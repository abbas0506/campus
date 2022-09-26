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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('prefix_id')->nullable();
            $table->string('father')->nullable();
            $table->string('phone', 15)->unique()->nullable();
            $table->string('cnic', 15)->unique();
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

            $table->unsignedBigInteger('department_id'); //parent department
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('jobtype_id')->nullable();
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('qualification_id')->nullable();
            $table->unsignedInteger('salaray')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('prefix_id')
                ->references('id')
                ->on('prefixes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('gender_id')
                ->references('id')
                ->on('genders')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('domicile_id')
                ->references('id')
                ->on('domiciles')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('religion_id')
                ->references('id')
                ->on('religions')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');  //cascade delete

            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('jobtype_id')
                ->references('id')
                ->on('jobtypes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('specialization_id')
                ->references('id')
                ->on('specializations')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('qualification_id')
                ->references('id')
                ->on('qualifications')
                ->onUpdate('cascade')
                ->onDelete('set null');


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
        Schema::dropIfExists('employees');
    }
};
