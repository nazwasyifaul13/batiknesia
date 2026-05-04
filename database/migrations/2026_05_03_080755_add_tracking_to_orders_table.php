
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('seller_id')->after('user_id')->nullable()->constrained('users');
            $table->string('tracking_number')->nullable()->after('status');
            $table->json('tracking_history')->nullable()->after('tracking_number');
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn(['seller_id', 'tracking_number', 'tracking_history', 'shipped_at', 'delivered_at']);
        });
    }
};