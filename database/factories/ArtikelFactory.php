<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artikel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'judul' => $this->faker->realText($maxNbChars = 50, $indexSize = 2),
            'isi' => $this->faker->realText($maxNbChars = 2000, $indexSize = 2)
            //
        ];
    }
}
