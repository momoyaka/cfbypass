<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->string('scheme')->nullable(false);
            $table->string('host')->nullable(false);
            $table->string('port')->nullable(false);
            $table->string('user')->nullable();
            $table->string('pass')->nullable();
            $table->boolean('is_working')->default(true);
            $table->timestamp('last_try')->nullable();
            $table->timestamps();

            $table->unique(['scheme','host', 'port']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxies');
    }
};
