<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio[]|\Cake\Collection\CollectionInterface $userestagios
 */
?>
<div class="container">
    <?= $this->Html->link(__('Novo usuário de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <h3><?= __('Usuário de estágios') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('categoria_id') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('estudante_id') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_id') ?></th>
                    <th><?= $this->Paginator->sort('professor_id') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userestagios as $userestagio): ?>
                    <tr>
                        <td><?= $userestagio->id ?></td>
                        <td><?= h($userestagio->email) ?></td>
                        <td><?= h($userestagio->categoria_id) ?></td>
                        <td><?= $userestagio->registro ?></td>
                        <td><?= $userestagio->hasValue('estudante') ? $this->Html->link($userestagio->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $userestagio->estudante->id]) : '' ?>
                        </td>
                        <td><?= $userestagio->hasValue('supervisor') ? $this->Html->link($userestagio->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $userestagio->supervisor->id]) : '' ?>
                        </td>
                        <td><?= $userestagio->hasValue('docente') ? $this->Html->link($userestagio->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $userestagio->docente->id]) : '' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $userestagio->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userestagio->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userestagio->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $this->element('templates'); ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
    </div>
    <?= $this->element('paginator_count') ?>
</div>