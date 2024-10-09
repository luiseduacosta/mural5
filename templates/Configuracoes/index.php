<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao[]|\Cake\Collection\CollectionInterface $configuracao
 */
?>
<?= $this->element('templates') ?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova Configuração'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <h3><?= __('Configurações') ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('mural_periodo_atual', 'Período do mural') ?></th>
                    <th><?= $this->Paginator->sort('termo_compromisso_periodo', 'Período do termo de compromisso') ?>
                    </th>
                    <th><?= $this->Paginator->sort('termo_compromisso_inicio', 'Data de início do termo de compromisso') ?>
                    </th>
                    <th><?= $this->Paginator->sort('termo_compromisso_final', 'Data de finalização do termo de compromisso') ?>
                    </th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($configuracao as $configuracao): ?>
                    <tr>
                        <td><?= $configuracao->id ?></td>
                        <td><?= h($configuracao->mural_periodo_atual) ?></td>
                        <td><?= h($configuracao->termo_compromisso_periodo) ?></td>
                        <td><?= h($configuracao->termo_compromisso_inicio) ?></td>
                        <td><?= h($configuracao->termo_compromisso_final) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $configuracao->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $configuracao->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $configuracao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $configuracao->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
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
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>