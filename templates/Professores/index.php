<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 page-header">
        <div>
            <h1 class="mb-1"><?= __('Professores(as)') ?></h1>
            <p class="text-muted mb-0">Lista dos docentes vinculados ao programa.</p>
        </div>

        <?php if ($user_data['categoria'] === '1'): ?>
            <div>
                <?= $this->Html->link(__('Novo professor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('nome') ?></th>
                            <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                            <th><?= $this->Paginator->sort('telefone') ?></th>
                            <th><?= $this->Paginator->sort('celular') ?></th>
                            <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                            <th><?= $this->Paginator->sort('dataingresso', 'Ingresso') ?></th>
                            <th><?= $this->Paginator->sort('departamento') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th><?= $this->Paginator->sort('estagiarios_count', 'Estagiários') ?></th>
                            <th><?= $this->Paginator->sort('dataegresso', 'Egresso') ?></th>
                            <th><?= $this->Paginator->sort('motivoegresso', 'Motivo') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($professores as $professor): ?>
                            <tr>
                                <td><?= $professor->id ?></td>
                                <td><?= $this->Html->link(h($professor->nome), ['controller' => 'professores', 'action' => 'view', $professor->id]) ?></td>
                                <td><?= $professor->siape ?></td>
                                <td><?= h($professor->telefone) ?></td>
                                <td><?= h($professor->celular) ?></td>
                                <td><?= h($professor->curriculolattes) ?></td>
                                <td><?= $professor->dataingresso ? $professor->dataingresso->format('d-m-Y') : '' ?></td>
                                <td><?= h($professor->departamento) ?></td>
                                <td><?= $professor->status !== null ? $professor->status : '' ?></td>
                                <td><?= $professor->estagiarios_count ?? 0 ?></td>
                                <td><?= $professor->dataegresso ? $professor->dataegresso->format('d-m-Y') : '' ?></td>
                                <td><?= h($professor->motivoegresso) ?></td>
                                <td class="actions d-flex gap-2 flex-wrap">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?php if ($user_data['categoria'] === '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?= $this->element('templates') ?>

    <div class="d-flex justify-content-center">
        <?= $this->element('paginator') ?>
    </div>
    <?= $this->element('paginator_count') ?>
</div>
