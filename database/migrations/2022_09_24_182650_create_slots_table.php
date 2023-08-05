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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheme_id');
            $table->unsignedInteger('semester_no');  //scheme's 
            $table->unsignedInteger('slot_no');         //1,2,3 
            $table->unsignedInteger('cr');
            $table->timestamps();

            $table->foreign('scheme_id')
                ->references('id')
                ->on('schemes')
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
        Schema::dropIfExists('slots');
    }
};
