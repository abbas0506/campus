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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short');
            $table->unsignedInteger('level');   //how many year eduction
            $table->unsignedInteger('credit_hrs');  //compulsory to pass
            $table->unsignedFloat('min_duration'); //in years
            $table->unsignedFloat('max_duration'); //in years
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('internal_id')->nullable();
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreign('internal_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
};
