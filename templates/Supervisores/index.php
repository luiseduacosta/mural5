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
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-0"><?= __('Supervisore(a)s') ?></h3>
        </div>
        <?php if ($user_data['categoria'] === '1'): ?>
            <div>
                <?= $this->Html->link(__('Nova supervisora'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('nome') ?></th>
                            <th><?= $this->Paginator->sort('cress') ?></th>
                            <th><?= $this->Paginator->sort('regiao') ?></th>
                            <th><?= $this->Paginator->sort('telefone') ?></th>
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
                                    <td><?= $this->Html->link($supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]) ?></td>
                                <?php else: ?>
                                    <td><?= $supervisor->nome ?></td>
                                <?php endif; ?>
                                <td><?= $supervisor->cress ?></td>
                                <td><?= $supervisor->regiao ?></td>
                                <td><?= h($supervisor->telefone) ?></td>
                                <td><?= h($supervisor->celular) ?></td>
                                <td><?= h($supervisor->email) ?></td>
                                <?php if ($user_data['categoria'] === '1'): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $supervisor->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $supervisor->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <div class="paginator">
            <ul class="pagination mb-2">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p class="text-center text-muted mb-0"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.')) ?></p>
        </div>
    </div>
</div>