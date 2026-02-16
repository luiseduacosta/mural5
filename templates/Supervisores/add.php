<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
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
                    <?= $this->Html->link(__('Listar supervisores'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

    <?= $this->Form->create($supervisor) ?>
        <fieldset>
            <legend><?= __('Nova supervisora') ?></legend>
            <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('cpf');
            echo $this->Form->control('endereco');
            echo $this->Form->control('bairro');
            echo $this->Form->control('municipio');
            echo $this->Form->control('cep');
            echo $this->Form->control('codigo_tel');
            echo $this->Form->control('telefone');
            echo $this->Form->control('codigo_cel');
            echo $this->Form->control('celular');
            if (isset($email)) {
                echo $this->Form->control('email', ['value' => $email, 'readonly']);
            } else {
                echo $this->Form->control('email', ['required']);
            }
            echo $this->Form->control('escola');
            echo $this->Form->control('ano_formatura');
            if (isset($cress)) {
                echo $this->Form->control('cress', ['value' => $cress, 'readonly']);
            } else {
                echo $this->Form->control('cress', ['required']);
            }
            echo $this->Form->control('regiao');
            echo $this->Form->control('outros_estudos');
            echo $this->Form->control('area_curso');
            echo $this->Form->control('ano_curso');
            echo $this->Form->control('cargo');
            echo $this->Form->control('num_inscricao');
            echo $this->Form->control('curso_turma');
            echo $this->Form->control('observacoes');
            echo $this->Form->control('instituicoes._ids', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>