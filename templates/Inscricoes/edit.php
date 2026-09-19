<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if (isset($user_data) && (($user_data['categoria'] === '1') || $user_data['aluno_id'])): ?>
                    <li class="nav-item">
                        <?=
                            $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $inscricao->id],
                            ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger me-2 float-end', 'style' => 'font-size: 10pt;']
                        )
                        ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size: 10pt;']) ?>
                </li>
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