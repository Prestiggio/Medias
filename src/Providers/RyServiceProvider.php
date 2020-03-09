<?php

namespace Ry\Medias\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Console\Scheduling\Schedule;
use Ry\Medias\Models\Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Ry\Medias\Console\Commands\PullEndpointCommand;
use Ry\Medias\Console\Commands\FileStatusChange;
use Ry\Medias\Console\Commands\Pull;

class RyServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
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
    	
    	$this->app->register(\Ry\Socin\Providers\RyServiceProvider::class);
    	
    	$this->map();
    	
    	$this->app->booted(function () {
    	    $schedule = $this->app->make(Schedule::class);
    	    //delete 2 days old unlinked medias
    	    $schedule->call(function(){
    	        $medias = Media::whereMediableId(0)->where("created_at", "<", Carbon::now()->subDay(2))->get();
    	        foreach($medias as $media) {
    	            if(Storage::disk(env('PUBLIC_DISK', 'public'))->delete(str_replace('storage/', '', $media->path))) {
    	                $media->delete();
    	            }
    	        }
    	    })->cron(env('MEDIAS_PURGE', '0 0 * * *'));
    	});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("rymedias.ls", function(){
            return new PullEndpointCommand();
        });
        $this->app->singleton("rymedias.status", function(){
            return new FileStatusChange();
        });
        $this->app->singleton("rymedias.pull", function(){
            return new Pull();
        });
        $this->commands(["rymedias.ls", "rymedias.status", "rymedias.pull"]);
    }
    public function map()
    {   
    	$this->app['router']->model('media', "\Ry\Medias\Models\Media");
    	if (! $this->app->routesAreCached()) {
    		$this->app['router']->group(['namespace' => 'Ry\Medias\Http\Controllers'], function(){
    			require __DIR__.'/../Http/routes.php';
    		});
    	}
    }
}
