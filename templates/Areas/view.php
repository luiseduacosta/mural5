<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerArea"
                aria-controls="navbarTogglerArea" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerArea">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
                </li>
                <?php if ($user_data['administrador_id']): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar área de instituição'), ['action' => 'edit', $area->id], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova área de instituição'), ['action' => 'add'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir área de instituição'), ['action' => 'delete', $area->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $area->id), 'class' => 'btn btn-danger me-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= h($area->area) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Área') ?></th>
                <td><?= h($area->area) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($area->id) ?></td>
            </tr>
        </table>
    </div>
</div>