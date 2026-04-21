<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
?>

<?= $this->element('templates') ?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Edita atividade'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-primary me-2 float-end', 'style' => 'font-size: 10pt;']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir atividade'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger me-2', 'style' => 'font-size: 10pt;']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar atividades'), ['action' => 'index', '?' => ['estagiario_id' => $folhadeatividade->estagiario_id]], ['class' => 'btn btn-primary me-2 float-end', 'style' => 'font-size: 10pt;']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', '?' => ['estagiario_id' => $folhadeatividade->estagiario_id]], ['class' => 'btn btn-primary me-2 float-end', 'style' => 'font-size: 10pt;']) ?>
                </li>
            </ul>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Atividade') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->atividade) ?></dd>
        </div>
    </dl>
</div>