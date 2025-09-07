<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->enum('type', ['email', 'reply', 'note']);
            $table->longText('message');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};
