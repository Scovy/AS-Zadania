<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 50)->unique();
            $table->timestamps();
        });

        // Seed default statuses
        DB::table('application_statuses')->insert([
            ['nazwa' => 'Nowa', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'W trakcie', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Zaakceptowana', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Odrzucona', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('application_statuses');
    }
};
