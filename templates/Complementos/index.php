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
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-1"><?= __('Complemento de estagiário') ?></h1>
            <p class="text-muted mb-0">Relação geral dos complementos cadastrados no sistema.</p>
        </div>
        <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'btn btn-primary me-2']) ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
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
        </div>
    </div>

    <?= $this->element('templates') ?>

    <div class="d-flex justify-content-center mt-4">
        <?= $this->element('paginator') ?>
    </div>
    <?= $this->element('paginator_count') ?>
</div>