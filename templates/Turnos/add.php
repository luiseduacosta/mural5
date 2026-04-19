<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turno $turno
 */
?>

<div class="container">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar turnos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <?= $this->Form->create($turno) ?>
    <fieldset>
        <legend><?= __('Novo turno') ?></legend>
        <?php
        echo $this->Form->control('turno', ['label' => ['text' => 'Turno'], 'required' => true, 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-end mt-3">
        <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
