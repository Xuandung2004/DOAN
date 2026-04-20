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
        Schema::create('thanhtoan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donhangID')->constrained('donhang')->cascadeOnDelete();
            $table->string('magiaodich')->nullable();
            $table->decimal('sotien', 15, 2);
            $table->string('manganhang')->nullable();
            $table->string('maphanhoi')->nullable();
            $table->timestamp('thoigianthanhtoan')->nullable();
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanhtoan');
    }
};