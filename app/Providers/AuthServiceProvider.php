<?php

namespace App\Providers;

use App\Models\Setting;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\RouteRegistrar;

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
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //默认令牌发放的有效期是永久
        Passport::tokensExpireIn(Carbon::now()->addMinutes(300));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(60));
        Passport::routes(function (RouteRegistrar $router) {
            //不需要那么多路由，对于密码授权的方式只要这几个路由就可以了
            $router->forAccessTokens();
        });
        Gate::define('setting', function ($user){

        });
        //
    }
}
