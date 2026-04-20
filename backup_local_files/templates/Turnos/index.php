<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turno[]|\Cake\Collection\CollectionInterface $turnos
 */
?>
<div class="container">
    <?php if ($user_data['administrador_id']): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerTurnos"
                aria-controls="navbarTogglerTurnos" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerTurnos">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo turno'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <h3><?= __('Turnos') ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('turno') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnos as $turno): ?>
                    <tr>
                        <td><?= $this->Number->format($turno->id) ?></td>
                        <td><?= h($turno->turno) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $turno->id]) ?>
                            <?php if ($user_data['administrador_id']): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $turno->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $turno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $turno->id)]) ?>
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
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.')) ?></p>
        </div>
    </div>
</div>
