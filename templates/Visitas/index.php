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
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-0"><?= __('Visitas institucionais') ?></h3>
        </div>
        <?php if ($user_data['categoria'] === '1'): ?>
            <div>
                <?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
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
                                <td><?= $visita->hasValue('instituicao') ? $this->Html->link($visita->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao->id]) : '' ?></td>
                                <td><?= date('d-m-Y', strtotime(h($visita->data))) ?></td>
                                <td><?= h($visita->motivo) ?></td>
                                <td><?= h($visita->responsavel) ?></td>
                                <td><?= h($visita->avaliacao) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $visita->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?php if ($user_data['categoria'] === '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $visita->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $visita->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <div class="paginator text-center">
            <ul class="pagination mb-2">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p class="mb-0 text-muted"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do total em {{count}}.')) ?></p>
        </div>
    </div>
</div>
