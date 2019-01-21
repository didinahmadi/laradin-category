<?php

namespace Laradin\Category;	

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laradin\Category\Helpers\Helper;

class CategoryServiceProvider extends ServiceProvider
{
	const NAME = 'laradin-category';

	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/config/category.php', 'category'
		);

		$this->loadRoutes();
	}

	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__.'/../resources/lang', self::NAME);
		$this->loadViewsFrom(__DIR__.'/../resources/views', self::NAME);

		$this->publishes([
	        __DIR__.'/../resources/lang' => resource_path('lang/vendor/' . self::NAME),
	    ], self::NAME.'-lang');

		$this->publishes([
			__DIR__ . '/config/category.php' => config_path('category.php')
		], self::NAME.'-config');

		$this->publishes([
			__DIR__  . '/../database/migrations' => database_path('migrations')
		], self::NAME.'-migrations');
	}


	/**
	 * Load category routes
	 * 
	 * @return void
	 */ 
	public function loadRoutes()
	{
		$group = array_merge(
			[
				'prefix'     => 'admin',
				'middleware' => [ 'web', 'auth' ]
			],
			config('category.route.group')
		);

		Route::group($group, function ($router) {
            $routeRegistrar = new RouteRegistrar($router);
			$routeRegistrar->all();
        });		
	}
}