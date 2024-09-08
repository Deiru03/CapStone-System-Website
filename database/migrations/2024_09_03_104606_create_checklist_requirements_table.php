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
        Schema::create('checklist_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requirement_id');
            $table->string('name');
            $table->boolean('complied')->default(false);
            $table->boolean('not_complied')->default(false);
            $table->boolean('not_applicable')->default(false);
            $table->timestamps();

            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_requirements');
    }
};
