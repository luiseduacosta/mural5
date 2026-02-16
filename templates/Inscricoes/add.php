<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>

<?= $this->element('templates') ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerEstagiario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($user->isAdmin() || $user->isStudent()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($inscricaoentity, ['method' => 'post']) ?>
        <fieldset>
            <legend><?= __('Inscrição para seleção de estágio') ?></legend>
            <?php
            if ($user->isAdmin()):
                echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => $alunos, 'empty' => ['0' => 'Seleciona aluno']]);
                echo $this->Form->control('registro', ['type' => 'hidden']);
                echo $this->Form->control('muralestagio_id', ['label' => ['text' => 'Mural de estágio'], 'options' => $muralestagios, 'value' => $muralestagio_id, 'empty' => ['0' => 'Seleciona instituição']]);
                echo $this->Form->control('data', ['value' => date('d-m-Y'), 'readonly']);
                echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo]);
                echo $this->Form->control('timestamp', ['type' => 'hidden']);
                echo $this->Form->control('alunoestagiario_id', ['type' => 'hidden']);
                // die(pr($user->categoria_id));
            elseif ($user->isStudent()):
                echo $this->Form->control('aluno_id', ['label' => 'Aluno', 'options' => $alunos, 'value' => $aluno_id, 'readonly']);
                echo $this->Form->control('muralestagio_id', ['label' => 'Mural de estágio', 'options' => $muralestagios, 'value' => $muralestagio_id, 'readonly']);
                echo $this->Form->control('data', ['type' => 'hidden', 'value' => date('Y-m-d'), 'readonly']);
                echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo, 'readonly']);
                echo $this->Form->control('timestamp', ['type' => 'hidden']);
                echo $this->Form->control('alunoestagiario_id', ['type' => 'hidden']);
            endif;
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>