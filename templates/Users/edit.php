<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
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
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <?php if($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?=
                            $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $userestagio->id],
                                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $userestagio->id), 'class' => 'btn btn-danger float-end']
                            )
                            ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($userestagio) ?>
        <fieldset>
            <legend><?= __('Editar  usuário') ?></legend>
            <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('categoria_id');
            echo $this->Form->control('registro');
            echo $this->Form->control('aluno_id', ['options' => $alunos, 'empty' => true]);
            echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
            echo $this->Form->control('professor_id', ['options' => $professores, 'empty' => true]);
            echo $this->Form->control('timestamp');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>