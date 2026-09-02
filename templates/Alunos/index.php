<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface|array<\App\Model\Entity\Aluno> $alunos
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
            <h1 class="mb-1"><?= __('Lista de Alunos(as)') ?></h1>
            <p class="text-muted mb-0">Relação geral dos estudantes cadastrados no sistema.</p>
        </div>

        <?php if (($user_data['categoria'] === '1') || $user_data['aluno_id']) : ?>
            <div class="d-flex flex-wrap gap-2">
                <?php if ($user_data['categoria'] === '1') : ?>
                    <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                    <?= $this->Html->link(__('Buscar Aluno'), ['action' => 'busca'], ['class' => 'btn btn-outline-secondary']) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="paginator px-3 pt-3">
                <?= $this->element('paginator'); ?>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <?php if ($user_data['categoria'] === '1') : ?>
                                <th class="actions"><?= __('Ações') ?></th>
                                <th><?= $this->Paginator->sort('id') ?></th>
                            <?php endif; ?>
                            <th><?= $this->Paginator->sort('nome') ?></th>
                            <th><?= $this->Paginator->sort('registro') ?></th>
                            <th><?= $this->Paginator->sort('email') ?></th>
                            <th><?= $this->Paginator->sort('telefone') ?></th>
                            <th><?= $this->Paginator->sort('celular') ?></th>
                            <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                            <th><?= $this->Paginator->sort('ingresso', 'Ingresso') ?></th>
                            <th><?= $this->Paginator->sort('Turnos.turno', 'Turno') ?></th>
                            <th><?= $this->Paginator->sort('inscricao_count', 'Inscrições') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno) : ?>
                        <tr>
                            <?php if ($user_data['categoria'] === '1') : ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que deseja excluir {0}?', $aluno->nome), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                            </td>
                            <td><?= $this->Html->link((string)$aluno->id, ['action' => 'view', $aluno->id]) ?></td>
                            <?php endif; ?>
                            <td><?= $aluno->nome ? $this->Html->link(h($aluno->nome), ['action' => 'view', $aluno->id]) : '' ?></td>
                            <td><?= h($aluno->registro) ?></td>
                            <td><?= $aluno->email ? $this->Html->link(h($aluno->email), ['mailto' => $aluno->email]) : '' ?></td>
                            <td><?= h($aluno->telefone ?? '') ?></td>
                            <td><?= h($aluno->celular ?? '') ?></td>
                            <td><?= h($aluno->cpf) ?></td>
                            <td><?= h($aluno->ingresso ?? 's/d') ?></td>
                            <td><?= h($aluno->TurnoID->turno ?? '') ?></td>
                            <td><?= h($aluno->inscricao_count) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="paginator px-3 pb-3">
                <?= $this->element('paginator'); ?>
                <?= $this->element('paginator_count'); ?>
            </div>
        </div>
    </div>
</div>
