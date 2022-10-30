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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('father')->nullable();
            $table->string('phone', 15)->unique()->nullable();
            $table->string('cnic', 15)->unique();

            $table->unsignedBigInteger('department_id'); //parent department
            $table->unsignedBigInteger('designation_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');  //cascade delete

            $table->foreign('designation_id')
                ->references('id')
                ->on('designations')
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
        Schema::dropIfExists('teachers');
    }
};
