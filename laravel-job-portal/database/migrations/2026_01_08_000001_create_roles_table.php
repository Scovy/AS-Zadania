<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 50)->unique();
            $table->timestamps();
        });

        // Seed default roles
        DB::table('roles')->insert([
            ['nazwa' => 'gosc', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'kandydat', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'pracodawca', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
