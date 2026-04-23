<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento[]|\Cake\Collection\CollectionInterface $complementos
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerComplemento"
                aria-controls="navbarTogglerComplemento" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerComplemento">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'btn btn-primary me-2 float-end', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Complemento de estagiário') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('periodo_especial') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($complementos as $complemento): ?>
                <tr>
                    <td><?= $complemento->id ?></td>
                    <td><?= h($complemento->periodo_especial) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $complemento->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $complemento->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $complemento->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $complemento->id)]) ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('templates') ?>

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