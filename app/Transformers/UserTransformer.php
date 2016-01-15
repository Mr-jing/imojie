<?php

namespace Imojie\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform($user)
    {
        return array_except($user->toArray(), $user->hidden);
    }
}