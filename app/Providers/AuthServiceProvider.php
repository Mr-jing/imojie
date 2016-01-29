<?php

namespace Imojie\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('update-topic', function ($user, $topic) {
            return $user->id === $topic->uid;
        });

        $gate->define('delete-topic', function ($user, $topic) {
            return $user->id === $topic->uid;
        });

        $gate->define('delete-reply', function ($user, $reply) {
            $isReplyOwner = $user->id === $reply->user_id;
            $isTopicOwner = $user->id === $reply->topic->id;

            return $isReplyOwner || $isTopicOwner;
        });
    }
}