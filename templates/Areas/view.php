<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerArea"
            aria-controls="navbarTogglerArea" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerArea">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar áreas'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <?php if ($categoria == 1): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar área'), ['action' => 'edit', $area->id], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova área'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir área'), ['action' => 'delete', $area->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $area->id), 'class' => 'btn btn-danger float-end']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3>
            <?= __('Área') ?>
        </h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Área') ?></th>
                <td><?= h($area->area) ?></td>
            </tr>
        </table>
    </div>
</div>