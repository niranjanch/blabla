<?php

namespace Niranjanch\Blabla;
 
use Illuminate\Support\ServiceProvider;
 
class BlaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
 
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['bla'] = $this->app->share(function($app) {
			return new Bla;
		});
    }
}
