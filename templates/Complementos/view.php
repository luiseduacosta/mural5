<?php
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <?= $this->Html->link(__('Listar registros'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?php if ($user_data['categoria'] === '1'): ?>
        <?= $this->Html->link(__('Editar registro'), ['action' => 'edit', $complemento->id], ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->postLink(__('Excluir registro'), ['action' => 'delete', $complemento->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $complemento->id), 'class' => 'btn btn-danger']) ?>
        <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</div>

<div class="container">
    <h3><?= h($complemento->id) ?></h3>
    <table class="table table-responsive table-striped table-hover">
        <tr>
            <th><?= __('Periodo Especial') ?></th>
            <td><?= h($complemento->periodo_especial) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($complemento->id) ?></td>
        </tr>
    </table>
</div>

<div class="container">
    <h4><?= __('Estagiários') ?></h4>
    <?php if (!empty($complemento->estagiarios)): ?>
        <table class="table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Registro') ?></th>
                <th><?= __('Nivel') ?></th>
                <th><?= __('Tc') ?></th>
                <th><?= __('Tc Solicitacao') ?></th>
                <th><?= __('Instituicao') ?></th>
                <th><?= __('Supervisor') ?></th>
                <th><?= __('Professor') ?></th>
                <th><?= __('Periodo') ?></th>
                <th><?= __('Nota') ?></th>
                <th><?= __('CH') ?></th>
                <th><?= __('Complemento Id') ?></th>
                <th><?= __('Ajuste2020') ?></th>
                <th><?= __('Observacoes') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
            <?php foreach ($complemento->estagiarios as $estagiarios): ?>
                <tr>
                    <td><?= h($estagiarios->id) ?></td>
                    <td><?= h($estagiarios->registro) ?></td>
                    <td><?= h($estagiarios->nivel) ?></td>
                    <td><?= h($estagiarios->tc) ?></td>
                    <td><?= h($estagiarios->tc_solicitacao) ?></td>
                    <td><?= h($estagiarios->instituicao_id) ?></td>
                    <td><?= h($estagiarios->supervisor_id) ?></td>
                    <td><?= h($estagiarios->professor_id) ?></td>
                    <td><?= h($estagiarios->periodo) ?></td>
                    <td><?= h($estagiarios->nota) ?></td>
                    <td><?= h($estagiarios->ch) ?></td>
                    <td><?= h($estagiarios->complemento_id) ?></td>
                    <td><?= h($estagiarios->ajuste2020) ?></td>
                    <td><?= h($estagiarios->observacoes) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                        <?php if ($user_data['categoria'] === '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $estagiarios->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>