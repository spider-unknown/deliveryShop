<?php

namespace App\Providers;

use App\Services\Api\V1\Core\AuthService;
use App\Services\Api\V1\Core\impl\AuthServiceImpl;
use App\Services\Api\V1\impl\ProductServiceImplV1;
use App\Services\Api\V1\ProductServiceV1;
use App\Services\Common\V1\Support\CodeService;
use App\Services\Common\V1\Support\FileService;
use App\Services\Common\V1\Support\impl\CodeServiceImpl;
use App\Services\Common\V1\Support\impl\FileServiceImpl;
use App\Services\Common\V1\Support\impl\OneSignalPushServiceImpl;
use App\Services\Common\V1\Support\OneSignalPushService;
use App\Services\Web\V1\impl\ProfileWebServiceImpl;
use App\Services\Web\V1\ProfileWebService;
use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        //API
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthServiceImpl(new CodeServiceImpl());
        });

        $this->app->bind(CodeService::class, function ($app) {
            return new CodeServiceImpl();
        });
        $this->app->bind(FileService::class, function ($app) {
            return new FileServiceImpl();
        });
        $this->app->bind(ProductServiceV1::class, function ($app) {
            return new ProductServiceImplV1();
        });
        $this->app->bind(OneSignalPushService::class, function ($app) {
            return new OneSignalPushServiceImpl();
        });

        //WEB
        $this->app->bind(ProfileWebService::class, function ($app) {
            return new ProfileWebServiceImpl(new FileServiceImpl());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
