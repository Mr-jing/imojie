<?php

namespace Imojie\Transformers;

use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user'
    ];

    public function transform($topic)
    {
        return $topic->toArray();
    }

    public function includeUser($topic)
    {
        $user = $topic->user;

        return $this->item($user, new UserTransformer());
    }
}