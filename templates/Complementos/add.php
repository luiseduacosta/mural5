<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
declare(strict_types=1);
?>

<?php echo $this->element('templates') ?>

<div class="container" style="margin-top: 10px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <?= $this->Html->link(__('Listar complementos'), ['action' => 'index'], ['class' => 'btn btn-primary me-2']) ?>
        <?= $this->Html->link(__('Ver'), ['action' => 'view'], ['class' => 'btn btn-primary me-2']) ?>
    </div>

    <div class="complementos form content">
        <?= $this->Form->create($complemento) ?>
        <fieldset>
            <legend><?= __('Novo registro') ?></legend>
            <?php
            echo $this->Form->control('periodo_especial', ['label' => 'Período especial']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>