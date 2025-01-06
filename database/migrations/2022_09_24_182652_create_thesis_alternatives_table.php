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
        Schema::create('thesis_alternatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_option_id');
            $table->unsignedBigInteger('alt1_id');
            $table->unsignedBigInteger('alt2_id');
            $table->tinyInteger('alt1_cr')->default(0);
            $table->tinyInteger('alt2_cr')->default(0);

            $table->timestamps();

            $table->foreign('slot_option_id')->references('id')->on('slot_options')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('alt1_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('alt2_id')->references('id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thesis_alternatives');
    }
};
