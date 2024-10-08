<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
       {
           Schema::table('users', function (Blueprint $table) {
               $table->string('program')->nullable(); // Add program column
               $table->string('position')->nullable();  // Add status column
           });
       }

       public function down()
       {
           Schema::table('users', function (Blueprint $table) {
               $table->dropColumn(['program', 'position']); //default for the data column of status is position same din sa users
           });
       }
};
