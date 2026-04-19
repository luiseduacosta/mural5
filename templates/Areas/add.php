<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>

<?= $this->element('templates') ?>

<div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerArea"
            aria-controls="navbarTogglerArea" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerArea">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar áreas'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($area, ['class' => 'form-group']) ?>
        <fieldset>
            <legend><?= __('Nova área') ?></legend>
            <?php
            echo $this->Form->control('area', ['label' => ['text' => 'Área'], 'class' => 'form-control']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Incluir'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>