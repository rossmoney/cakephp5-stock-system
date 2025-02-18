<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Table\ProductsTable;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductsController Test Case
 *
 * @uses \App\Controller\ProductsController
 */
class ProductsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @uses \App\Controller\ProductsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/products');

        $this->assertResponseOk();
        $this->assertResponseContains('Products'); // Check if the response contains 'Products'
        $this->assertResponseContains('A product'); // Check if the response contains a product name

        $products = $this->viewVariable('products');
        $this->assertNotEmpty($products); // Check if products variable is set
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\ProductsController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $data = [
            'name' => 'Best product Evar!',
            'price' => '1.99',
            'quantity' => '2',
        ];
        $this->post('/products/add', $data);

        //assert the record was changed
        $result = $this->Products->get(2);

        $this->assertEquals('Best product Evar!', $result->name);
        $this->assertEquals('1.99', $result->price);

        //assert that some sort of session flash was set.
        $this->assertSession('The product has been saved.', 'Flash.flash.0.message');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\ProductsController::edit()
     */
    public function testEdit(): void
    {
        $this->enableCsrfToken();
        $data = [
            'name' => 'Updated product name',
            'price' => '2.99',
        ];
        $this->put('/products/edit/1', $data);

        //assert the record was changed
        $result = $this->Products->get(1);
        $this->assertEquals('Updated product name', $result->name);
        $this->assertEquals('2.99', $result->price);

        //assert that some sort of session flash was set.
        $this->assertSession('The product has been saved.', 'Flash.flash.0.message');
        $this->assertRedirect(['controller' => 'Products', 'action' => 'index']);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\ProductsController::delete()
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->delete('/products/delete/1');

        //assert the record was marked as deleted
        $result = $this->Products->get(1);
        $this->assertTrue($result->deleted);

        //assert that some sort of session flash was set.
        $this->assertSession('The product has been deleted.', 'Flash.flash.0.message');
        $this->assertRedirect(['controller' => 'Products', 'action' => 'index']);
    }
}
