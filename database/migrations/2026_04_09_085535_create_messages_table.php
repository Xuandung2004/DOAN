<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tinnhan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoiguiID')->constrained('nguoidung')->cascadeOnDelete();
            $table->foreignId('nguoinhanID')->constrained('nguoidung')->cascadeOnDelete();
            $table->text('noidung');
            $table->tinyInteger('dadoc')->default(0);
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tinnhan');
    }
};