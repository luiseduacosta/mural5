<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface|array<\App\Model\Entity\Aluno> $alunos
 */
declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => '0'];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>
<div class="alunos index content">
    <?php if ($user_data['administrador_id'] || $user_data['aluno_id']) : ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light  w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" 
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <?php if ($user_data['administrador_id']) : ?>
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button ms-2', 'style' => 'font-size: 10pt;']) ?>
                        <?= $this->Html->link(__('Buscar Aluno'), ['action' => 'busca'], ['class' => 'button ms-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>
    <h3><?= __('Lista de Alunos(as)') ?></h3>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <?php if ($user_data['administrador_id']) : ?>
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
                    <?php if ($user_data['administrador_id']) : ?>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete {0}?', $aluno->nome)]) ?>
                    </td>
                    <td><?= $this->Html->link((string)$aluno->id, ['action' => 'view', $aluno->id]) ?></td>
                    <?php endif; ?>
                    <td><?= $aluno->nome ? $this->Html->link(h($aluno->nome), ['action' => 'view', $aluno->id]) : '' ?></td>
                    <td><?= h($aluno->registro) ?></td>
                    <td><?= $aluno->email ? $this->Html->link(h($aluno->email), ['mailto' => $aluno->email]) : '' ?></td>
                    <?php if (!empty((string)$aluno->telefone) && strlen((string)$aluno->telefone) < 10) : ?>
                        <td><?= $aluno->telefone ? '(' . $aluno->codigo_telefone . ') ' . h($aluno->telefone) : '' ?></td>
                    <?php else : ?>
                        <td><?= h($aluno->telefone) ?></td>
                    <?php endif; ?>
                    <?php if (!empty((string)$aluno->celular) && strlen((string)$aluno->celular) < 10) : ?>
                        <td><?= $aluno->celular ? '(' . $aluno->codigo_celular . ') ' . h($aluno->celular) : '' ?></td>
                    <?php else : ?>
                        <td><?= h($aluno->celular) ?></td>
                    <?php endif; ?>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->ingresso) ?? 's/d' ?></td>
                    <td><?= h($aluno->TurnoID->turno ?? '') ?></td>
                    <td><?= h($aluno->inscricao_count) ?></td>
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
