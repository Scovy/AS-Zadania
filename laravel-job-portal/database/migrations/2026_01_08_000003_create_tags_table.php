<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 50)->unique();
            $table->timestamps();
        });

        // Seed popular IT technologies
        DB::table('tags')->insert([
            ['nazwa' => 'PHP', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Laravel', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'JavaScript', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'TypeScript', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'React', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Vue.js', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Angular', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Node.js', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Python', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Django', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Java', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Spring', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'C#', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => '.NET', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Go', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Rust', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Docker', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Kubernetes', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'AWS', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Azure', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'GCP', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'PostgreSQL', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'MySQL', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'MongoDB', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Redis', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Linux', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'Git', 'created_at' => now(), 'updated_at' => now()],
            ['nazwa' => 'CI/CD', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
