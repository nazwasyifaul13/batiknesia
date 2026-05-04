<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Hapus kolom is_read_admin jika ada
        if (Schema::hasColumn('chats', 'is_read_admin')) {
            Schema::table('chats', function (Blueprint $table) {
                $table->dropColumn('is_read_admin');
            });
        }
        
        // Pastikan kolom is_read ada
        if (!Schema::hasColumn('chats', 'is_read')) {
            Schema::table('chats', function (Blueprint $table) {
                $table->boolean('is_read')->default(false)->after('sender');
            });
        }
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            if (!Schema::hasColumn('chats', 'is_read_admin')) {
                $table->boolean('is_read_admin')->default(false)->after('is_read');
            }
        });
    }
};