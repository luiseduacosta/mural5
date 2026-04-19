<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turno $turno
 */
?>
<div class="container">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar turnos'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <?php if (isset($categoria) && $categoria == 1): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar turno'), ['action' => 'edit', $turno->id], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir turno'), ['action' => 'delete', $turno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $turno->id), 'class' => 'btn btn-danger me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo turno'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <h3><?= h($turno->turno) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Turno') ?></th>
            <td><?= h($turno->turno) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($turno->id) ?></td>
        </tr>
    </table>
</div>
