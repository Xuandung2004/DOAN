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
        Schema::create('donhang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoidungID')->constrained('nguoidung')->cascadeOnDelete();
            $table->decimal('tongtien', 15, 2);
            $table->text('diachigiaohang');
            $table->string('phuongthucthanhtoan');
            $table->tinyInteger('trangthaithanhtoan')->default(0)->comment('0 chờ, 1 đã thanh toán');
            $table->tinyInteger('trangthaidon')->default(0)->comment('0 chờ, 1 đang giao, 2 hoàn tất, 3 hủy');
            $table->foreignId('magiamgiaID')->nullable()->constrained('magiamgia')->nullOnDelete();
            $table->decimal('sotiengiam', 15, 2)->default(0);
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donhang');
    }
};