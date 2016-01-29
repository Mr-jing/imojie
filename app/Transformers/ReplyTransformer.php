<?php

namespace Imojie\Transformers;

use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user'
    ];

    public function transform($reply)
    {
        return $reply->toArray();
    }

    public function includeUser($reply)
    {
        $user = $reply->user;

        return $this->item($user, new UserTransformer());
    }
}