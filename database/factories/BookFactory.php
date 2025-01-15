<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

//this factory is used to generate dummy data for testing
class BookFactory extends Factory
{
    //corresponding model for the factory
    protected $model = Book::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */

    //generating fake data about books
    public function definition()
    {
        return [
            'title' => $this->faker->sentence, //random name for the author.
            'author' => $this->faker->name, //random name for the author
            'category' => $this->faker->word, //random word for the category
            'synopsis'=> $this->faker->paragraph, //random paragraph for the synopsis
            'published_at'=> $this->faker->date //random publication date
        ];
    }
}
