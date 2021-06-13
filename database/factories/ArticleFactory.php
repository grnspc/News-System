<?php

namespace GrnSpc\News\Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use GrnSpc\News\Models\Article;
use GrnSpc\News\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'content' => $this->faker->paragraphs(5, true),
            'date' => Carbon::now(),
        ];
    }
}
