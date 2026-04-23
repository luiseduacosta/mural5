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
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova Configuração'), ['action' => 'add'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
                </li>

            </ul>
        </div>
    </nav>

<h3><?= __('Configurações') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
                    <th><?= $this->Paginator->sort('id') ?></th>
                <?php endif; ?>
                <th><?= $this->Paginator->sort('mural_periodo_atual', 'Período do mural') ?></th>
                <th><?= $this->Paginator->sort('termo_compromisso_periodo', 'Período do termo de compromisso') ?></th>
                <th><?= $this->Paginator->sort('termo_compromisso_inicio', 'Data de início do termo de compromisso') ?>
                </th>
                <th><?= $this->Paginator->sort('termo_compromisso_final', 'Data de finalização do termo de compromisso') ?>
                </th>
                <th><?= $this->Paginator->sort('periodo_calendario_academico', 'Período calendário acadêmico') ?>
                </th>
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

<?= $this->element("templates") ?>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
        <?= $this->Paginator->prev('< ' . __('anterior')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('próximo') . ' >') ?>
        <?= $this->Paginator->last(__('último') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
    </p>
</div>