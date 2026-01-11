<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['nazwa'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isAdmin(): bool
    {
        return $this->nazwa === 'admin';
    }

    public function isEmployer(): bool
    {
        return $this->nazwa === 'pracodawca';
    }

    public function isCandidate(): bool
    {
        return $this->nazwa === 'kandydat';
    }
}
