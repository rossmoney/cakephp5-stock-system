<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 */
class ProductsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'A product',
                'quantity' => 1,
                'price' => 3,
                'status' => 'low stock',
                'created' => date('Y-m-d H:i:s'),
                'last_updated' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}
