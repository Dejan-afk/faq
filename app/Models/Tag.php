<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /* Scopes */

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /* Relationships */
    
    public function faqs()
    {
        return $this->belongsToMany(Faq::class, 'faq_tag')->withTimestamps(); // Mit Timestamps, um die Beziehung zu verfolgen
    }
}
