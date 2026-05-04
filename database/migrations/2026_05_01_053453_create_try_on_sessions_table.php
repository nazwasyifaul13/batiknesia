<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('try_on_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('original_image')->nullable();
            $table->string('generated_image')->nullable();
            $table->foreignId('selected_motif_id')->nullable()->constrained('batik_patterns')->onDelete('set null');
            $table->text('recommendation')->nullable();
            $table->json('ai_response_data')->nullable();
            $table->string('skin_tone_detected')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('try_on_sessions');
    }
};