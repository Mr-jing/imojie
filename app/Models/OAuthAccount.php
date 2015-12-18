<?php

namespace Imojie\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthAccount extends Model
{
    protected $table = 'oauth_accounts';

    public $timestamps = false;

//    public function getDates()
//    {
//        return ['created_at'];
//    }
}
