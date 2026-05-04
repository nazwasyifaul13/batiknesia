<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambah kolom qr_code
            if (!Schema::hasColumn('products', 'qr_code')) {
                $table->string('qr_code')->nullable()->after('image');
            }
            // Tambah kolom motif_id
            if (!Schema::hasColumn('products', 'motif_id')) {
                $table->foreignId('motif_id')->nullable()->constrained('batik_patterns')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('qr_code');
            $table->dropForeign(['motif_id']);
            $table->dropColumn('motif_id');
        });
    }
};