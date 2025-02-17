<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

/**
 * Products seed.
 */
class ProductsSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        $data = [];
        $quantity = 0;
        $status = $quantity <= 0 ? 'out of stock' : ($quantity > 10 ? 'in stock' : 'low stock');
        $data[] = [
            'name' => $faker->word,
            'quantity' => $quantity,
            'price' => $faker->randomFloat(2, 1, 10000),
            'status' => $status,
            'created' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d H:i'),
            'last_updated' => date('Y-m-d H:i', time()),
        ];

        for ($i = 0; $i < 3; $i++) {
            $quantity = $faker->numberBetween($min = 1, $max = 10);
            $status = $quantity <= 0 ? 'out of stock' : ($quantity > 10 ? 'in stock' : 'low stock');
            $data[] = [
                'name' => $faker->word,
                'quantity' => $quantity,
                'price' => $faker->randomFloat(2, 1, 10000),
                'status' => $status,
                'created' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d H:i'),
                'last_updated' => date('Y-m-d H:i', time()),
            ];
        }

        for ($i = 0; $i < 3; $i++) {
            $quantity = $faker->numberBetween($min = 0, $max = 500);
            $status = $quantity <= 0 ? 'out of stock' : ($quantity > 10 ? 'in stock' : 'low stock');
            $data[] = [
                'name' => $faker->word,
                'quantity' => $quantity,
                'price' => $faker->randomFloat(2, 1, 1000),
                'status' => $status,
                'created' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d H:i'),
                'last_updated' => date('Y-m-d H:i', time()),
            ];
        }

        for ($i = 0; $i < 3; $i++) {
            $quantity = $faker->numberBetween($min = 11, $max = 1000);
            $status = $quantity <= 10 ? 'low stock' : ($quantity > 10 ? 'in stock' : 'out of stock');
            $data[] = [
                'name' => $faker->word,
                'quantity' => $quantity,
                'price' => $faker->randomFloat(2, 1, 10000),
                'status' => $status,
                'created' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d H:i'),
                'last_updated' => date('Y-m-d H:i', time()),
            ];
        }

        $table = $this->table('products');
        $table->insert($data)->save();
    }
}
