<?php

namespace Laradin\Category\Tests;

use Orchestra\Testbench\TestCase;
use Laradin\Category\Http\Requests\CategoryRequest;

class CategoryRequestTest extends TestCase
{
    /**
     * Test rule definition
     * 
     * @return void
     */
    public function test_rule_definition()
    {
        $request = new CategoryRequest;
        $this->assertEquals([
            'parent_id'     => 'nullable|numeric',
            'name'          => 'required|max:50',
            'description'   => 'nullable|max:255',
            'active'        => 'nullable'
        ], $request->rules());
    }
}
