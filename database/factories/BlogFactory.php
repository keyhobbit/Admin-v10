<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        $status = fake()->randomElement(['draft', 'published']);
        
        return [
            'title' => $title,
            'slug' => Blog::generateSlug($title),
            'excerpt' => fake()->paragraph(),
            'content' => '<p>' . fake()->paragraphs(3, true) . '</p>',
            'image' => fake()->imageUrl(800, 400, 'technology', true),
            'category' => fake()->randomElement(['Announcements', 'Guides', 'Updates', 'Events']),
            'author' => fake()->name(),
            'status' => $status,
            'published_at' => $status === 'published' ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    /**
     * Indicate that the blog is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now()->subDays(rand(1, 30)),
        ]);
    }

    /**
     * Indicate that the blog is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
