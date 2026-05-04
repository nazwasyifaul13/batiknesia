
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['article', 'video']);
            $table->text('content')->nullable(); // untuk artikel
            $table->string('youtube_url')->nullable(); // untuk video
            $table->string('thumbnail')->nullable();
            $table->string('author')->nullable();
            $table->text('excerpt')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education');
    }
};