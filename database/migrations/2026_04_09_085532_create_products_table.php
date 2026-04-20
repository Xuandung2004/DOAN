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
        Schema::create('sanpham', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danhmucID')->constrained('danhmuc')->cascadeOnDelete();
            $table->string('ten');
            $table->string('duongdan')->unique();
            $table->text('mota')->nullable();
            $table->decimal('gia', 15, 2);
            $table->decimal('giagiam', 15, 2)->nullable();
            $table->integer('soluong')->default(0);
            $table->tinyInteger('trangthai')->default(1)->comment('0 = Inactive, 1 = Active');
            $table->float('diemtrungbinh')->default(0);
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanpham');
    }
};