<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tableNames = config('news.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/news.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['articles'], function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image')->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT'])->default('PUBLISHED');
            $table->date('date');
            $table->boolean('featured')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create($tableNames['article_tag'], function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create($tableNames['categories'], function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create($tableNames['tags'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        app('cache')
            ->store(config('news.cache.store') != 'default' ? config('news.cache.store') : null)
            ->forget(config('news.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/news.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }
        Schema::drop($tableNames['articles']);
        Schema::drop($tableNames['article_tag']);
        Schema::drop($tableNames['categories']);
        Schema::drop($tableNames['tags']);
    }
}
