<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?php $usuario = $this->getRequest()->getAttribute('identity'); ?>

<?= $this->element('templates') ?>

<div class="container">

    <?php
    if (isset($usuario) && $usuario->categoria_id == 1): ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar usuário(a)s do mural de estagios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']); ?>
                    </li>
                </ul>
            </div>
        </nav>

    <?php endif; ?>

    <div class="container">
        <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Cadastro de novo usuário(a)') ?></legend>
            <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password', ['label' => ['text' => 'Senha']]);
            echo $this->Form->control('categoria_id', ['options' => ['2' => 'Aluno', '3' => 'Professor(a)', '4' => 'Supervisor']]);
            echo $this->Form->control('registro', ['label' => ['text' => 'DRE, Siape ou Cress']]);
            echo $this->Form->control('aluno_id', ['type' => 'hidden', 'options' => $alunos, 'empty' => true]);
            echo $this->Form->control('supervisor_id', ['type' => 'hidden', 'options' => $supervisores, 'empty' => true]);
            echo $this->Form->control('professor_id', ['type' => 'hidden', 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('timestamp', ['type' => 'hidden', date('Y-m-d')]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>