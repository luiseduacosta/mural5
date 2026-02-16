<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
// pr($inscricao);
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
                        <?=
                            $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $inscricao->id],
                            ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger float-end']
                        )
                        ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($inscricao) ?>
        <fieldset>
            <legend><?= __('Editar Inscricao') ?></legend>
            <?php
            echo $this->Form->control('registro', ['value' => $inscricao->registro, 'readonly']);
            echo $this->Form->control('aluno_id', ['options' => [$inscricao->aluno_id => $inscricao->aluno->nome], 'empty' => $inscricao->aluno->nome, 'readonly']);
            echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
            echo $this->Form->control('data');
            echo $this->Form->control('periodo');
            echo $this->Form->control('timestamp');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>