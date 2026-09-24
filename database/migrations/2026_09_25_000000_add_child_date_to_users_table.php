<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Due date while expecting, birth date afterwards.
            $table->date('child_date')->nullable()->after('parent_type');
            $table->date('arrival_snoozed_until')->nullable()->after('child_date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['child_date', 'arrival_snoozed_until']);
        });
    }
};
