<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 100)->unique();
            $table->integer('kolejnosc')->default(0);
            $table->timestamps();
        });

        // Seed default categories
        DB::table('categories')->insert([
            ['nazwa' => 'Backend', 'kolejnosc' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Frontend', 'kolejnosc' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Fullstack', 'kolejnosc' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'DevOps', 'kolejnosc' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'SysAdmin', 'kolejnosc' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Data Science', 'kolejnosc' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'QA', 'kolejnosc' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Project Manager', 'kolejnosc' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
