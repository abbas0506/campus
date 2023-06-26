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
        Schema::table('scheme_details', function (Blueprint $table) {
            //
            $table->unsignedInteger('slot')->after('semester_no');         //1,2,3 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheme_details', function (Blueprint $table) {
            //
            $table->dropColumn('slot');
        });
    }
};
