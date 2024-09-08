<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clearance_checklists', function (Blueprint $table) {
            $table->string('document_name')->after('id'); // Adjust the position as needed
        });
    }
 
    public function down()
    {
        Schema::table('clearance_checklists', function (Blueprint $table) {
            $table->dropColumn('document_name');
        });
    }
};
