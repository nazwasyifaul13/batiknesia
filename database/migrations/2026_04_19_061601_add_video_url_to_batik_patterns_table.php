<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('batik_patterns', function (Blueprint $table) {
            // Cek apakah kolom video_url sudah ada, jika belum maka tambahkan
            if (!Schema::hasColumn('batik_patterns', 'video_url')) {
                $table->string('video_url')->nullable()->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('batik_patterns', function (Blueprint $table) {
            if (Schema::hasColumn('batik_patterns', 'video_url')) {
                $table->dropColumn('video_url');
            }
        });
    }
};