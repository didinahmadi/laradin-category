<?php 

return [
	'table' => 'laradin_categories',

	'route' => [
		'group' 	 => [
			'middleware' => ['web', 'auth'],
			'prefix' => 'admin',
		],
		'name' => 'laradin-category'		
	]
];