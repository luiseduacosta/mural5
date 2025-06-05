<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador[]|\Cake\Collection\CollectionInterface $administradores
 */
?>
<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAdministrador"
            aria-controls="navbarTogglerAdministrador" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerAdministrador">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo Administrador'), ['action' => 'add'], ['class' => 'button']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <h3><?= __('Lista de Administradores') ?></h3>

    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="row"><?= __('Actions') ?></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($administradores as $administrador): ?>
                    <tr>
                        <td class="row">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $administrador->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $administrador->id]) ?>
                            <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $administrador->id], ['confirm' => __('Are you sure you want to delete {0}?', $administrador->nome)]) ?>
                        </td>
                        <td><?= $this->Html->link($administrador->id, ['action' => 'view', $administrador->id]) ?></td>
                        <td><?= $this->Html->link($administrador->nome, ['action' => 'view', $administrador->id]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
        <?= $this->element('paginator_count'); ?>
    </div>
</div>