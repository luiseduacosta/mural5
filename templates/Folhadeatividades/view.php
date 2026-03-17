<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
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
                    <?= $this->Html->link(__('Edita atividade'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir atividade'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar atividades'), ['action' => 'index', '?' => ['estagiario_id' => $folhadeatividade->estagiario_id]], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', '?' => ['estagiario_id' => $folhadeatividade->estagiario_id]], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Atividade') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->atividade) ?></dd>
        </div>
    </dl>
</div>