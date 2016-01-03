<?php

namespace Imojie\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class TestController extends Controller
{
    public function __construct()
    {
    }


    public function testOAuth()
    {
        var_dump(Authorizer::getResourceOwnerId());
    }
}
