<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    /**
     * Pagination settings for the ProductsController.
     *
     * @var array<string, mixed>
     */
    public array $paginate = [
        'limit' => 5,
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $searchName = $this->request->getQuery('search');
        $sort = $this->request->getQuery('sort');
        $direction = $this->request->getQuery('direction');

        $query = $this->Products->find();
        $conditions = [];
        if (!empty($searchName)) {
            $conditions['name like'] = trim('%' . $searchName . '%', ' ');
        }
        $products = $this->paginate($query->where(['deleted' => 0])->where($conditions));

        $this->set(compact('products', 'searchName', 'sort', 'direction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success('The product has been saved.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The product could not be saved. Please, try again.');
        }
        $this->set(compact('product'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $product = $this->Products->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success('The product has been saved.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('The product could not be saved. Please, try again.');
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);

        $product->set('deleted', true);
        $this->Products->save($product);
        $this->Flash->success('The product has been deleted.');

        return $this->redirect(['action' => 'index']);
    }
}
