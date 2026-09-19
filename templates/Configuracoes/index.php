<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao[]|\Cake\Collection\CollectionInterface $configuracao
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
            <h1 class="mb-1"><?= __('Configurações') ?></h1>
            <p class="text-muted mb-0">Relação geral das configurações cadastradas no sistema.</p>
        </div>
        <?php if ($user_data['categoria'] === '1'): ?>
            <div>
                <?= $this->Html->link(__('Nova Configuração'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
        <thead class="thead-dark">
            <tr>
                <?php if ($user_data['categoria'] === '1'): ?>
                    <th>Id</th>
                <?php endif; ?>
                <th>Período do mural</th>
                <th>Período do termo de compromisso</th>
                <th>Data de início do termo de compromisso</th>
                <th>Data de finalização do termo de compromisso</th>
                <th>Período calendário acadêmico</th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($configuracao as $configura): ?>
                <tr>
                    <td><?= $configura->id ?></td>
                    <td><?= h($configura->mural_periodo_atual) ?></td>
                    <td><?= h($configura->termo_compromisso_periodo) ?></td>
                    <td><?= h($configura->termo_compromisso_inicio) ?></td>
                    <td><?= h($configura->termo_compromisso_final) ?></td>
                    <td><?= h($configura->periodo_calendario_academico) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $configura->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $configura->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $configura->id], ['confirm' => __('Tem certeza que deseja excluir a configuração # {0}?', $configura->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
