<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento[]|\Cake\Collection\CollectionInterface $complementos
 */
?>
<div class="complementos index content container">
    <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <h3><?= __('Complemento de estagiário') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('periodo_especial') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complementos as $complemento): ?>
                    <tr>
                        <td><?= $complemento->id ?></td>
                        <td><?= h($complemento->periodo_especial) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $complemento->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $complemento->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $complemento->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $complemento->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <?= $this->element('templates') ?>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>

        </div>
    </div>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>