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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // call, email, meeting, task
            $table->text('description')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->boolean('completed')->default(false);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->nullableMorphs('subject'); // related to contact or deal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
