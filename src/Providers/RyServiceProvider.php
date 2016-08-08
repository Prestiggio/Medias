<?php

namespace Ry\Medias\Providers;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RyServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
    	parent::boot($router);
    	/*
    	$this->publishes([    			
    			__DIR__.'/../config/rymedias.php' => config_path('rymedias.php')
    	], "config");  
    	$this->mergeConfigFrom(
	        	__DIR__.'/../config/rymedias.php', 'rymedias'
	    );
    	$this->publishes([
    			__DIR__.'/../assets' => public_path('vendor/rymedias'),
    	], "public");    	
    	*/
    	//ressources
    	$this->loadViewsFrom(__DIR__.'/../ressources/views', 'rymedias');
    	$this->loadTranslationsFrom(__DIR__.'/../ressources/lang', 'rymedias');
    	/*
    	$this->publishes([
    			__DIR__.'/../ressources/views' => resource_path('views/vendor/rymedias'),
    			__DIR__.'/../ressources/lang' => resource_path('lang/vendor/rymedias'),
    	], "ressources");
    	*/
    	$this->publishes([
    			__DIR__.'/../database/factories/' => database_path('factories'),
	        	__DIR__.'/../database/migrations/' => database_path('migrations')
	    ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
    public function map(Router $router)
    {    	
    	if (! $this->app->routesAreCached()) {
    		$router->group(['namespace' => 'Ry\Medias\Http\Controllers'], function(){
    			require __DIR__.'/../Http/routes.php';
    		});
    	}
    }
}