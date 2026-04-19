<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerTurmas"
            aria-controls="navbarTogglerTurmas" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerTurmas">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar turma de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <?php if (isset($categoria) && $categoria == 1): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar turma de estágio'), ['action' => 'edit', $turmaestagio->id], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir turma de estágio'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova turma de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<div class="container">
    <h3><?= h($turmaestagio->area) ?></h3>
    <table class="table table-stripted table-hover table-responsive">
        <tr>
            <th><?= __('Turma') ?></th>
            <td><?= h($turmaestagio->area) ?></td>
        </tr>
    </table>
</div>