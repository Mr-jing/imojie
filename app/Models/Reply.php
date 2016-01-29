<?php

namespace Imojie\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'topic_id',
        'original_content',
        'content',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

}
