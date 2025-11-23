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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            //$table->enum('is_read',['yes','no'])->default('no');
            $table->boolean('is_read')->default(false);
            $table->string('type')->nullable(); // info, success, warning, error
            $table->date('notification_expiry_date');
            $table->datetime('receive_time')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('staffaccount_id')
            ->constained('staffaccounts')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
