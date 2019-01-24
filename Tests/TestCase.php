<?php

namespace Laradin\Category\Tests;

use Orchestra\Testbench\TestCase as OrchestraTest;
use Laradin\Category\Category;
use Laradin\Category\Database\Seeds\CategoryTableSeeder;
use Illuminate\Support\Facades\Artisan;

class TestCase extends OrchestraTest
{

	protected $runSeeder = true;

	protected function getPackageProviders($app)
	{
	    return ['Laradin\Category\CategoryServiceProvider'];
	}

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
	        'driver'   => 'mysql',
	        'host' 	   => 'localhost',
	        'database' => 'laratest-test',
	        'prefix'   => '',
	        'username' => 'root',
	        'password' => ''
	    ]);	    
    }	
    
    public function setUp()
    {
        parent::setUp();
        
        $this->loadMigrationsFrom([
			'--database' => 'testing',
			'--path' => __DIR__ . '/../Database/migrations'
        ]);
        
        // run database seeder
		// it will insert initial data to database for testing purpose
		if ($this->runSeeder) {
			Artisan::call('db:seed', [
			'--class' => CategoryTableSeeder::class 
			]);
		}
    }

    public function test_generate_flatten_nested_categories()
    {   
        $list = Category::getList(null);
		$this->assertCount(18, $list);
		$flippedList = array_flip($list);

		$checkers = [
			"Big Cats",
			"Big Cats / Tiger",
			"Big Cats / Lion",
			"Big Cats / Jaguar",
			"Bird",
			"Fish",
			"Fish / Koi",
			"Fish / Koi / Kohaku",
			"Fish / Koi / Sanke",
			"Fish / Koi / Chagoi",
			"Fish / Koi / Tancho",
			"Fish / Cat Fish",
			"Fish / Cat Fish / Lele",
			"Fish / Cat Fish / Lele / Dumbo",
			"Fish / Cat Fish / Lele / Sangkuriang",
			"Fish / Cat Fish / Lele / Bule",
			"Fish / Cat Fish / Patin",
		];

		collect($checkers)->each(function ($c) use ($flippedList) {
			$this->assertArrayHasKey($c, $flippedList);
		});
    }

    public function test_table_name()
    {
        $this->assertEquals('laradin_categories', config('category.table'));
    }

	public function test_category_insertions()
	{
        $tableName = config('category.table');
		$this->assertDatabaseHas($tableName, [
			'parent_id' => null,
			'name' => 'Big Cats'
		]);

		$this->assertDatabaseHas($tableName, [
			'parent_id' => null,
			'name' => 'Fish'
		]);

		$this->assertDatabaseHas($tableName, [
			'parent_id' => null,
			'name' => 'Bird'
		]);

		$this->assertEquals(
			3, Category::where('name', 'Big Cats')->first()->childs->count()
		);

		$this->assertEquals(
			0, Category::where('name', 'Bird')->first()->childs->count()
		);

		$this->assertEquals(
			0, Category::where('name', 'Patin')->first()->childs->count()
		);

		$this->assertEquals(
			2, Category::where('name', 'Cat Fish')->first()->childs->count()
		);

		$this->assertEquals(
			2, Category::where('name', 'Fish')->first()->childs->count()
		);

		$this->assertEquals(
			4, Category::where('name', 'Koi')->first()->childs->count()
		);

		$this->assertEquals(
			3, Category::where('name', 'Lele')->first()->childs->count()
		);

        Category::query()->truncate();
        
        $this->assertEquals(0, Category::query()->count(), 'row count invalid after truncated');
	}    
}