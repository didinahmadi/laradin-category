<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('category.table');
        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->string('name', 50);
            $table->string('description', 255)->nullable();
            $table->tinyInteger('active')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on($tableName)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('category.table');
        Schema::dropIfExists($tableName);
    }
}
