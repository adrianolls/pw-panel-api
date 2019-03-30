<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Hash\BinSaltHasher;
use App\Hash\Base64Hasher;
use App\Hash\MD5Hasher;
use Illuminate\Support\Facades\Route;
use Illuminate\Hashing\BcryptHasher;
use Setting;

class HashServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hash', function () {

            // Implement Admin Hashing
            if (Route::current() == null) {
                return new BcryptHasher;
            } else if (Route::current()->getAction()['prefix'] === '/admin') {
                return new BcryptHasher;
            }

            switch (config('perfectworld.hash')) {
                case 'md5':
                    return new MD5Hasher();
                case 'base64':
                    return new Base64Hasher();
                case 'binsalt':
                    return new BinSaltHasher();
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hash'];
    }

}
