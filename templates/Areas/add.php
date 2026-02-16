<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
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
                <?php if($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">

    <div class="areas form content">
            <?= $this->Form->create($area) ?>
            <fieldset>
                <legend><?= __('Nova área instituição') ?></legend>
                <?php
                echo $this->Form->control('area', ['label' => ['text' => 'Área']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>