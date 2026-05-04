<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area[]|\Cake\Collection\CollectionInterface $areas
 */
?>

<div class="container">

    <?php if ($user_data['categoria'] === '1'): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerArea"
                    aria-controls="navbarTogglerArea" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerArea">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova área'), ['action' => 'add'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <h3><?= __('Área instituicoes') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areas as $area): ?>
                    <tr>
                        <td><?= $area->id ?></td>
                        <td><?= h($area->area) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $area->id]) ?>
                            <?php if ($user_data['categoria'] === '1'): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $area->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $area->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $area->id)]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('templates'); ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
    </div>
    <?= $this->element('paginator_count') ?>
</div>