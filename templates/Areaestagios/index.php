<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio[]|\Cake\Collection\CollectionInterface $areaestagios
 */
?>
<div class="container">
    <?= $this->Html->link(__('Nova área de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <h3><?= __('Áreas de estágios') ?></h3>
    <div class="table-responsive">
        <table class="table table-stripted table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areaestagios as $areaestagio): ?>
                    <tr>
                        <td><?= $areaestagio->id ?></td>
                        <td><?= h($areaestagio->area) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $areaestagio->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $areaestagio->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $areaestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areaestagio->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('templates') ?>
    <div class="d-flex justify-content-center">
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
    <br>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>