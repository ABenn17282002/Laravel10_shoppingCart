<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// Product,Stockモデルの使用
use App\Models\Product;
use App\Models\Stock;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    // Stockクラスの定義
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'type' => $this->faker->numberBetween(1,2),
            'quantity' => $this->faker->numberBetween(0,99),
        ];
    }
}
