<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerTurma"
            aria-controls="navbarTogglerTurma" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerTurma">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar turmas de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?= $this->Form->create($turmaestagio, ['class' => 'row']) ?>
    <legend><?= __('Nova turma de estágio') ?></legend>
    <div class="col-auto">
        <label for="area" class="form-label">Nova turma de estágio</label>
    </div>
    <div class="col-auto">
        <input type="text" class="form-control" id="area" placeholder="Digite a turma de estágio" name="area" required>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary mb-3">Confirmar</button>
    </div>
    <?= $this->Form->end() ?>

</div>