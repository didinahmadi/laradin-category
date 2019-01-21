<?php

namespace Laradin\Category;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar 
{

	protected $router;

	/**
	 * Create new RouteRegistrar instance
	 * 
	 * @param \Illuminate\Contracts\Routing\Registrar $router
	 * @return void
	 */ 
	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	/**
	 * Register resource route
	 * 
	 * @return void
	 */ 
	public function all()
	{
		$this->router->resource(
			config('category.route.name'), 
			'Laradin\Category\Http\Controllers\CrudController'
		);

		$this->router->get(config('category.route.name') . '/{category}/delete',
			'Laradin\Category\Http\Controllers\CrudController@delete'
		)->name(config('category.route.name').'.delete');
	}

}