<?php

namespace Imojie\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uid',
        'title',
        'original_content',
        'content',
        'active_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_hide', false)
            ->where('is_draft', false)
            ->orderBy('active_at', 'desc');
    }

    public function scopeExcellent($query)
    {
        return $query->where('is_hide', false)
            ->where('is_draft', false)
            ->where('is_excellent', true)
            ->orderBy('created_at', 'desc');
    }

    public function scopeHot($query)
    {
        return $query->where('is_hide', false)
            ->where('is_draft', false)
            ->orderBy('reply_count', 'desc');
    }

    public function scopeNewest($query)
    {
        return $query->where('is_hide', false)
            ->where('is_draft', false)
            ->orderBy('created_at', 'desc');
    }

}
