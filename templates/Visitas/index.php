<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita[]|\Cake\Collection\CollectionInterface $visitas
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">

    <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'btn btn-primary float-end', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

<h3><?= __('Visitas instituicionais') ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao_id') ?></th>
                    <th><?= $this->Paginator->sort('data') ?></th>
                    <th><?= $this->Paginator->sort('motivo') ?></th>
                    <th><?= $this->Paginator->sort('responsavel') ?></th>
                    <th><?= $this->Paginator->sort('avaliacao') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitas as $visita): ?>
                    <tr>
                        <td><?= $visita->id ?></td>
                        <td><?= $visita->hasValue('instituicao') ? $this->Html->link($visita->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao->id]) : '' ?>
                        </td>
                        <td><?= date('d-m-Y', strtotime(h($visita->data))) ?></td>
                        <td><?= h($visita->motivo) ?></td>
                        <td><?= h($visita->responsavel) ?></td>
                        <td><?= h($visita->avaliacao) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $visita->id]) ?>
                            <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $visita->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $visita->id)]) ?>
                            <?php endif; ?>
                        </td>
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
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do total em {{count}}.')) ?></p>
    </div>
</div>
