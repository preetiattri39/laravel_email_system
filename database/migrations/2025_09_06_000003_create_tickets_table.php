<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('email_id')->constrained('emails')->onDelete('cascade');
            $table->string('zoho_ticket_id')->nullable();
            $table->string('priority')->default('normal');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
