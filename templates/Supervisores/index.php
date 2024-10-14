<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor[]|\Cake\Collection\CollectionInterface $supervisores
 */
// pr($supervisores);
$user = $this->getRequest()->getAttribute('identity');
// pr($user['categoria_id']);
?>
<div class="container">
    <?php if ($user['categoria_id'] == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">

                        <?= $this->Html->link(__('Cadastra supervisora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                </ul>
            </div>
        </nav>

    <?php endif; ?>
    <h3><?= __('Supervisores') ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cress') ?></th>
                    <th><?= $this->Paginator->sort('regiao') ?></th>
                    <th><?= $this->Paginator->sort('codigo_tel', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_cel', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <?php if ($user['categoria_id'] == 1): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supervisores as $supervisor): ?>
                    <tr>
                        <td><?= $supervisor->id ?></td>
                        <?php if ($user['categoria_id'] == 1): ?>
                            <td><?= $this->Html->link($supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]) ?>
                            </td>
                        <?php else: ?>
                            <td><?= $supervisor->nome ?></td>
                        <?php endif; ?>
                        <td><?= $supervisor->cress ?></td>
                        <td><?= $supervisor->regiao ?></td>
                        <td><?= h($supervisor->codigo_tel) ?></td>
                        <td><?= h($supervisor->telefone) ?></td>
                        <td><?= h($supervisor->codigo_cel) ?></td>
                        <td><?= h($supervisor->celular) ?></td>
                        <td><?= h($supervisor->email) ?></td>
                        <?php if ($user['categoria_id'] == 1): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $supervisor->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $supervisor->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $supervisor->id)]) ?>
                            </td>
                        <?php endif; ?>
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