<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'description',
        'icon',
        'icon_bg',
        'icon_color',
        'tags',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'tags'      => 'array',
        'is_active' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────────

    /** Only active services, ordered for front-end display. */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /** Ordered by sort_order for admin listing. */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    // ── Helpers ──────────────────────────────────────────────

    /** Toggle active status and save. */
    public function toggleActive(): void
    {
        $this->update(['is_active' => !$this->is_active]);
    }
}

