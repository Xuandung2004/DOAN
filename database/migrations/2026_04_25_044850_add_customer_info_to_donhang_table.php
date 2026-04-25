<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donhang', function (Blueprint $table) {
            $table->string('tennguoinhan', 255)->after('nguoidungID');
            $table->string('sodienthoai', 20)->after('tennguoinhan');
        });
    }

    public function down(): void
    {
        Schema::table('donhang', function (Blueprint $table) {
            $table->dropColumn(['tennguoinhan', 'sodienthoai']);
        });
    }
};