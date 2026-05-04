<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor[]|\Cake\Collection\CollectionInterface $supervisores
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">

    <?php if ($user_data['categoria'] === '1'): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova supervisora'), ['action' => 'add'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <h3><?= __('Supervisore(a)s') ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cress') ?></th>
                    <th><?= $this->Paginator->sort('regiao') ?></th>
                    <th><?= $this->Paginator->sort('codigo_telefone', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_celular', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <?php if ($user_data['categoria'] === '1'): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supervisores as $supervisor): ?>
                    <tr>
                        <td><?= $supervisor->id ?></td>
                        <?php if ($user_data['categoria'] === '1'): ?>
                            <td><?= $this->Html->link($supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]) ?>
                            </td>
                        <?php else: ?>
                            <td><?= $supervisor->nome ?></td>
                        <?php endif; ?>
                        <td><?= $supervisor->cress ?></td>
                        <td><?= $supervisor->regiao ?></td>
                        <td><?= h($supervisor->codigo_telefone) ?></td>
                        <td><?= h($supervisor->telefone) ?></td>
                        <td><?= h($supervisor->codigo_celular) ?></td>
                        <td><?= h($supervisor->celular) ?></td>
                        <td><?= h($supervisor->email) ?></td>
                        <?php if ($user_data['categoria'] === '1'): ?>
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

<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.')) ?>
        </p>
    </div>
</div>