<?php

namespace Laradin\Category\Database\Seeds;

use Illuminate\Database\Seeder;
use Laradin\Category\Category;

class CategoryTableSeeder extends Seeder
{
	protected function create($data, $parentId = null)
	{
		$items = isset($data['items']) ? $data['items'] : null;
    	unset($data['items']);

    	$c = Category::create(array_merge([
        	'parent_id'   => $parentId,
            'name'        => 'Animal',
            'description' => $data['name'] . ' description',
            'active'      => 1
        ], $data));

        if ($items) {
        	foreach ($items as $item) {
        		$this->create($item, $c['id']);
        	}
        }
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
        	[
        		'name' => 'Big Cats',
        		'items' => [
        			[ 'name' => 'Tiger' ],
        			[ 'name' => 'Lion' ],
        			[ 'name' => 'Jaguar' ],
        		]
        	],
        	[
        		'name' => 'Bird'
        	],
        	[
        		'name' => 'Fish',
        		'items' => [
        			[
        				'name' => 'Koi',
	        			'items' => [
	        				[ 'name' => 'Kohaku' ],
	        				[ 'name' => 'Sanke' ],
	        				[ 'name' => 'Chagoi' ],
	        				[ 'name' => 'Tancho' ]
	        			]
        			],
        			[
        				'name' => 'Cat Fish',
	        			'items' => [
	        				[ 
	        					'name' => 'Lele',
	        					'items' => [
	        						[ 'name' => 'Dumbo' ],
	        						[ 'name' => 'Sangkuriang' ],
	        						[ 'name' => 'Bule' ],
	        					]
	        				],
	        				[ 'name' => 'Patin' ]
	        			]
        			]
        		]
        	],
        ];

        foreach ($items as $item) {        	
        	$this->create($item);
        }
    }
}
