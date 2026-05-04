<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'seller', 'user'])->default('user')->after('email');
            $table->enum('seller_status', ['pending', 'approved', 'rejected'])->nullable()->after('role');
            $table->string('store_name')->nullable()->after('seller_status');
            $table->text('store_description')->nullable()->after('store_name');
            $table->string('avatar')->nullable()->after('store_description');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'seller_status', 'store_name', 'store_description', 'avatar']);
        });
    }
};