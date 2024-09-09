<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clearance_checklists', function (Blueprint $table) {
            $table->id();
            //$table->string('document_name'); // Ensure this line is present
            $table->string('name');
            $table->integer('units');
            $table->string('type');
            $table->string('table_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clearance_checklists');
    }
};
