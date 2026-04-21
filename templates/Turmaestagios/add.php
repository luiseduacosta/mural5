<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav ms-auto mt-lg-0">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar turmas de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end', 'style' => 'font-size: 10pt;']) ?>
            </li>
        </ul>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($turmaestagio) ?>
    <fieldset>
        <legend><?= __('Nova turma de estágio') ?></legend>
        <?php
        echo $this->Form->control('area', ['label' => ['text' => 'Turma'], 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirma', ['class' => 'btn btn-primary'])) ?>
    </div>
    <?= $this->Form->end() ?>
</div>