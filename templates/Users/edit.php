<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerUsereEdit"
            aria-controls="navbarTogglerUserEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerUserEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-link">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Tem certeza que quer excluir este usuário # {0}?', $user->id), 'class' => 'btn btn-danger float-start']
                )
                ?>
            </li>
        <li class="nav-link">
            <?= $this->Html->link(__('Listar usuários'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
        <?php endif; ?>
    </ul>
</nav>

    <div class="container">
        <?= $this->Form->create($userestagio) ?>
        <fieldset>
            <legend><?= __('Editar  usuário') ?></legend>
            <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('categoria', ['options' => ['2' => 'Aluno', '3' => 'Professor(a)', '4' => 'Supervisor']]);
            echo $this->Form->control('registro');
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