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
    Schema::create('guardiao_df', function (Blueprint $table) {
        $table->id();
        $table->text('texto_original'); 
        $table->text('texto_mascarado')->nullable(); 
        $table->decimal('score_risco', 5, 2)->default(0); 
        $table->json('dados_identificados')->nullable(); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardiao_df');
    }
};
