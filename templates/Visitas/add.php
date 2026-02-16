<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
?>

<?= $this->element('templates') ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerVisita"
            aria-controls="navbarTogglerVisita" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerVisita">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($visita) ?>
        <fieldset>
            <legend><?= __('Nova visita') ?></legend>
            <?php
            echo $this->Form->control('instituicao_id', ['options' => $instituicoes]);
            echo $this->Form->control('data');
            echo $this->Form->control('motivo');
            echo $this->Form->control('responsavel');
            echo $this->Form->control('descricao');
            echo $this->Form->control('avaliacao');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>