<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'current_lat')) {
                $table->decimal('current_lat', 10, 8)->nullable()->default(-6.200000);
            }
            if (!Schema::hasColumn('orders', 'current_lng')) {
                $table->decimal('current_lng', 11, 8)->nullable()->default(106.816666);
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['current_lat', 'current_lng']);
        });
    }
};