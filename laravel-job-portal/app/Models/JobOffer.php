<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class JobOffer extends Model
{
    protected $fillable = [
        'company_profile_id',
        'category_id',
        'tytul',
        'opis',
        'wynagrodzenie_min',
        'wynagrodzenie_max',
        'lokalizacja',
        'typ_pracy',
        'wazna_do',
        'aktywna',
    ];

    protected $casts = [
        'wazna_do' => 'datetime',
        'aktywna' => 'boolean',
        'wynagrodzenie_min' => 'decimal:2',
        'wynagrodzenie_max' => 'decimal:2',
    ];

    public function companyProfile(): BelongsTo
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'job_offer_tag');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // Scopes for filtering
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('aktywna', true)
                     ->where(function ($q) {
                         $q->whereNull('wazna_do')
                           ->orWhere('wazna_do', '>=', now());
                     });
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByTag(Builder $query, int $tagId): Builder
    {
        return $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('tags.id', $tagId);
        });
    }

    public function scopeByTags(Builder $query, array $tagIds): Builder
    {
        return $query->whereHas('tags', function ($q) use ($tagIds) {
            $q->whereIn('tags.id', $tagIds);
        });
    }

    public function scopeBySalary(Builder $query, ?float $min, ?float $max): Builder
    {
        if ($min) {
            $query->where(function ($q) use ($min) {
                $q->whereNull('wynagrodzenie_max')
                  ->orWhere('wynagrodzenie_max', '>=', $min);
            });
        }
        if ($max) {
            $query->where(function ($q) use ($max) {
                $q->whereNull('wynagrodzenie_min')
                  ->orWhere('wynagrodzenie_min', '<=', $max);
            });
        }
        return $query;
    }

    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('lokalizacja', 'ILIKE', "%{$location}%");
    }

    public function scopeByWorkType(Builder $query, string $type): Builder
    {
        return $query->where('typ_pracy', $type);
    }

    public function getSalaryRangeAttribute(): string
    {
        if ($this->wynagrodzenie_min && $this->wynagrodzenie_max) {
            return number_format($this->wynagrodzenie_min, 0, ',', ' ') . ' - ' . 
                   number_format($this->wynagrodzenie_max, 0, ',', ' ') . ' PLN';
        }
        if ($this->wynagrodzenie_min) {
            return 'od ' . number_format($this->wynagrodzenie_min, 0, ',', ' ') . ' PLN';
        }
        if ($this->wynagrodzenie_max) {
            return 'do ' . number_format($this->wynagrodzenie_max, 0, ',', ' ') . ' PLN';
        }
        return 'Nie podano';
    }

    public function getWorkTypeLabel(): string
    {
        return match($this->typ_pracy) {
            'remote' => 'Zdalnie',
            'hybrid' => 'Hybrydowo',
            'office' => 'Stacjonarnie',
            default => $this->typ_pracy,
        };
    }
}
