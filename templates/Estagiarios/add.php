<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
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
                <?php if ($user->isAdmin() || $user->isProfessor()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar estagiários'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($estagiario) ?>
        <fieldset>
            <legend><?= __('Novo estagiário') ?></legend>
            <?php
            if (isset($aluno_id)) {
                echo $this->Form->control('aluno_id', ['options' => $alunos, 'value' => $aluno_id]);
                echo $this->Form->control('registro', ['value' => $estudanteestagiarios->registro]);
                echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Nao', '1' => 'Sim']]);
                echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos', 'I' => 'Indeterminado'], 'value' => $estudanteestagiarios->turno]);
                echo $this->Form->control('nivel', ['label' => ['text' => 'Nivel de estagio'], 'options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '9' => 'Extra-curricular'], 'value' => $estudantedeestagio->nivel]);
            } else {
                echo $this->Form->control('aluno_id', ['options' => $alunos, 'empty' => 'Seleciona']);
                echo $this->Form->control('registro');
                echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Nao', '1' => 'Sim']]);
                echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos', 'I' => 'Indeterminado']]);
                echo $this->Form->control('nivel', ['label' => ['text' => 'Nivel de estagio'], 'options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '9' => 'Extra-curricular']]);
            }

            echo $this->Form->control('tc', ['label' => ['text' => 'Termo de compromisso'], 'options' => [0 => "Nao", 1 => "Sim"]]);
            echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data de solicitaçao do TC'], 'empty' => true, 'value' => new DateTime()]);

            if (isset($aluno_id)) {
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituicoes de estagio'], 'options' => $instituicoes, 'value' => $estudantedeestagio->instituicao_id]);
                echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'value' => $estudantedeestagio->supervisor_id]);
                echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor(a) de OTP'], 'options' => $professores, 'value' => $estudantedeestagio->professor_id]);
            } else {
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituicoes de estagio'], 'options' => $instituicoes, 'empty' => "Seleciona"]);
                echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => "Seleciona"]);
                echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor(a) de OTP'], 'options' => $professores, 'empty' => "Seleciona"]);
            }
            echo $this->Form->control('periodo', ['value' => $periodo]);
            echo $this->Form->control('turmaestagio_id', ['label' => ['text' => 'Turma de estagio'], 'options' => $turmaestagios, 'empty' => "Seleciona"]);
            echo $this->Form->control('complemento_id', ['label' => ['text' => 'Tipo de estágio (Pandemia)'], 'options' => [1 => 'Remoto', 2 => 'Ple'], 'empty' => "Seleciona"]);
            echo $this->Form->control('nota');
            echo $this->Form->control('ch', ['label' => ['text' => 'Carga horaria']]);
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Outras informacoes']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary me-1']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>