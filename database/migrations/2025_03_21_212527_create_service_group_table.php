<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Service_Group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreignId('Service_id')->references('id')->on('Services')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_group');
    }
};
