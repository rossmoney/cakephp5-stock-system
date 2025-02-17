<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="products form content">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <legend><?= __('Add Product') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('quantity', ['type' => 'number']);
            echo $this->Form->control('price', ['type' => 'number']);
            echo $this->Form->control('status', [
                'type' => 'select',
                'disabled' => true,
                'options' => ['in stock' => 'in stock', 'low stock' => 'low stock', 'out of stock' => 'out of stock'],
            ]);
            ?>
    </fieldset>
    <?= $this->Form->button(__('Save Product')) ?>
    <?= $this->Form->end() ?>
</div>
