<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsTable Test Case
 */
class ProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsTable
     */
    protected $Products;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Products') ? [] : ['className' => ProductsTable::class];
        $this->Products = $this->getTableLocator()->get('Products', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Products);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $data = [
            'name' => 'Test Product',
            'quantity' => 10,
            'price' => 99.99,
            'status' => 'in stock',
        ];

        $product = $this->Products->newEntity($data);
        $this->assertEmpty($product->getErrors());

        $data['name'] = ''; // Invalid name
        $product = $this->Products->newEntity($data);
        $this->assertNotEmpty($product->getErrors()['name']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $data = [
            'name' => 'Unique Product',
            'quantity' => 10,
            'price' => 99.99,
            'status' => 'in stock',
        ];

        $product = $this->Products->newEntity($data);
        $this->Products->save($product);
        $this->assertEmpty($product->getErrors());

        $duplicateProduct = $this->Products->newEntity($data);
        $this->Products->save($duplicateProduct);
        $this->assertNotEmpty($duplicateProduct->getErrors()['name']);
    }

    /**
     * Test findOrCreate method
     *
     * @return void
     */
    public function testFindOrCreate(): void
    {
        $search = ['name' => 'Nonexistent Product'];
        $callback = function ($entity) {
            $entity->quantity = 5;
            $entity->price = 49.99;
            $entity->status = 'in stock';
        };

        $product = $this->Products->findOrCreate($search, $callback);
        $this->assertNotEmpty($product);
        $this->assertEquals(5, $product->quantity);
        $this->assertEquals(49.99, $product->price);
        $this->assertEquals('low stock', $product->status);
    }
}
