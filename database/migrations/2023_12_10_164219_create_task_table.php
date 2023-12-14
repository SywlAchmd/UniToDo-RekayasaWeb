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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            // $table->string('title')->nullable(false);
            // $table->string('description')->nullable(true);
            // $table->timestamp('deadline')->nullable(false);
            // $table->string('status')->nullable(false);
            // $table->string('course')->nullable(false);
            $table->string('title');
            $table->string('description');
            $table->timestamp('deadline');
            $table->string('status');
            $table->string('course');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
