<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['nazwa', 'kolejnosc'];

    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class);
    }
}
