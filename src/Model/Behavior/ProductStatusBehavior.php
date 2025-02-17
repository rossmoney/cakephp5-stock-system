<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;

class ProductStatusBehavior extends Behavior
{
    /**
     * Before save event.
     *
     * @param \Cake\Event\EventInterface $event The beforeSave event.
     * @param \Cake\Datasource\EntityInterface $entity The entity being saved.
     * @param \ArrayObject $options The options passed to the save method.
     * @return void
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {
        if ($entity->quantity <= 0) {
            $entity->set('status', 'out of stock');
        }

        if ($entity->quantity > 10) {
            $entity->set('status', 'in stock');
        }

        if ($entity->quantity > 0 && $entity->quantity <= 10) {
            $entity->set('status', 'low stock');
        }
    }
}
