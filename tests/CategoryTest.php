<?php

namespace Laradin\Category\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Laradin\Category\Category;
use Laradin\Category\Temperature;
use Laradin\Category\Database\Seeds\CategoryTableSeeder;


use Mockery as m;

class CategoryTest extends TestCase {

	use RefreshDatabase;	

 	protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
	        'driver'   => 'mysql',
	        'host' 	   => 'localhost',
	        'database' => 'laratest-test',
	        'prefix'   => '',
	        'username' => 'root',
	        'password' => 'root'
	    ]);	    
    }	

	public function setUp()
	{
		parent::setUp();

		$this->loadLaravelMigrations(['--database' => 'testing']);
		$this->loadMigrationsFrom([
			'--database' => 'testing',
			'--path' => __DIR__ . '/../database/migrations'
		]);

		(new \DatabaseSeeder())->call(CategoryTableSeeder::class);
	}  

	protected function getPackageProviders($app)
	{
	    return ['Laradin\Category\CategoryServiceProvider'];
	}

	public function tearDown()
	{
		m::close();
	}

	// public function testMock()
	// {
	// 	$service = m::mock('service');
	// 	$service->shouldReceive('readTemp')
	// 			->times(3)
	// 			->andReturn(10, 12, 14);
	// 	$temprature = new Temperature($service);
	// 	$this->assertEquals(12, $temprature->average());
	// }

	public function testDataInsertion()
	{
		$this->assertDatabaseHas(config('category.tableName'), [
			'parent_id' => null,
			'name' => 'Big Cats'
		]);

		$this->assertDatabaseHas(config('category.tableName'), [
			'parent_id' => null,
			'name' => 'Fish'
		]);

		$this->assertDatabaseHas(config('category.tableName'), [
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
	}


	public function testGenerateList()
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

	public function testGenerateListNested()
	{
		$this->assertTrue(true);
	}

	
}