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
        Schema::create('donhangchitiet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donhangID')->constrained('donhang')->cascadeOnDelete();
            $table->foreignId('sanphamID')->constrained('sanpham')->cascadeOnDelete();
            $table->integer('soluong');
            $table->decimal('gia', 15, 2);
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donhangchitiet');
    }
};