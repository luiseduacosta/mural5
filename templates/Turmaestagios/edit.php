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
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger me-1']) ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar turma de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <?= $this->Form->create($turmaestagio, ['class' => 'row']) ?>
    <legend><?= __('Editar turma de estágio') ?></legend>
    <div class="col-auto">
        <label for="area" class="form-label">Editar turma de estágio</label>
    </div>
    <div class="col-auto">
        <?= $this->Form->control('area', ['label' => false, 'id' => 'area', 'name' => 'area', 'required' => true, 'class' => 'form-control col-12']); ?>
    </div>
    <div class="col-auto">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary mb-3']) ?>
    </div>
    <?= $this->Form->end() ?>

</div>