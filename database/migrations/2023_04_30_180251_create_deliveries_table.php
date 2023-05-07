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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->nullable()
                ->index()
                ->constrained(table: 'users')
                ->nullOnDelete();
            $table->foreignId('dispatcher_id')
                ->nullable()
                ->index()
                ->constrained(table: 'users')
                ->nullOnDelete();
            $table->string('sender');
            $table->string('receiver');
            $table->string('loading_location');
            $table->string('destination');
            $table->timestamp('arrival_time');
            $table->json('cargo');
            $table->string('status');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
