<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('milestone_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('milestone_key', 100);
            $table->timestamps();

            $table->unique(['user_id', 'milestone_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('milestone_checks');
    }
};
