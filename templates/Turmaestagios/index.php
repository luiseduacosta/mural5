<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio[]|\Cake\Collection\CollectionInterface $turmaestagios
 */
?>

<?php $usuario = $this->getRequest()->getAttribute('identity'); ?>

<div class="container">

    <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                    aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova turma de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <h3><?= __('Turmas de estágios') ?></h3>

    <div class="table-responsive">
        <table class="table table-stripted table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turmaestagios as $turmaestagio): ?>
                    <tr>
                        <td><?= $turmaestagio->id ?></td>
                        <td><?= h($turmaestagio->area) ?></td>
                        <td>
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $turmaestagio->id], ['class' => 'link-info']) ?>
                            <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $turmaestagio->id], ['class' => 'link-warning']) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $turmaestagio->id), 'class' => 'link-danger']) ?>
                            <?php endif; ?>
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