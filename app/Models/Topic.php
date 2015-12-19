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
}
