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
        Schema::create('transcripts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recording_id')->constrained()->onDelete('cascade');
            $table->longText('content');
            $table->json('segments')->nullable(); // with timestamps and speakers
            $table->json('keywords')->nullable();
            $table->string('sentiment')->nullable(); // positive/neutral/negative
            $table->string('language')->default('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcripts');
    }
};
