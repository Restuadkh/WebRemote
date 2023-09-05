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
        Schema::create('log_apaches', function (Blueprint $table) {
            $table->id();
            $table->integer("id_user"); 
            $table->integer("id_server"); 
            $table->string("datetime"); 
            $table->string("method");  
            $table->text('uri')->nullable(); 
            $table->integer("status"); 
            $table->integer("bytes"); 
            $table->text('user_agent')->nullable(); 
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_apaches');
    }
};
