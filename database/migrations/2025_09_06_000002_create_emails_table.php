<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique();
            $table->string('from_name')->nullable();
            $table->string('from_email');
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->json('headers')->nullable();
            $table->foreignId('lead_id')->nullable()->constrained('leads')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
