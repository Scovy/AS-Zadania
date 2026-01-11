<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('tytul', 200);
            $table->text('opis');
            $table->decimal('wynagrodzenie_min', 10, 2)->nullable();
            $table->decimal('wynagrodzenie_max', 10, 2)->nullable();
            $table->string('lokalizacja', 100);
            $table->enum('typ_pracy', ['remote', 'hybrid', 'office'])->default('office');
            $table->timestamp('wazna_do')->nullable();
            $table->boolean('aktywna')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
