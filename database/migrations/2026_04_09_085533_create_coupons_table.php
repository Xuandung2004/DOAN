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
        Schema::create('magiamgia', function (Blueprint $table) {
            $table->id();
            $table->string('ma')->unique();
            $table->string('loai');
            $table->decimal('giatri', 15, 2);
            $table->decimal('giatridontoithieu', 15, 2)->default(0);
            $table->integer('gioihansudung')->nullable();
            $table->integer('dasudung')->default(0);
            $table->timestamp('hethan')->nullable();
            $table->timestamp('ngaytao')->useCurrent();
            $table->timestamp('ngaycapnhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magiamgia');
    }
};