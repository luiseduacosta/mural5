<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
// pr($estudantedeestagio);
?>
<?= $this->element('templates') ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Listar estagiários'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="container">
        <?= $this->Form->create($estagiario) ?>
        <fieldset>
            <legend><?= __('Novo estagiário') ?></legend>
            <?php
            if (isset($estudante_id)) {
                echo $this->Form->control('estudante_id', ['options' => $estudantes, 'value' => $estudante_id]);
                echo $this->Form->control('registro', ['value' => $estudanteestagiarios->registro]);
                echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Nao', '1' => 'Sim']]);
                echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos', 'I' => 'Indeterminado'], 'value' => $estudanteestagiarios->turno]);
                echo $this->Form->control('nivel', ['label' => ['text' => 'Nivel de estagio'], 'options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '9' => 'Extra-curricular'], 'value' => $estudantedeestagio->nivel]);
            } else {
                echo $this->Form->control('estudante_id', ['options' => $estudantes, 'empty' => 'Seleciona']);
                echo $this->Form->control('registro');
                echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Nao', '1' => 'Sim']]);
                echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'A' => 'Ambos', 'I' => 'Indeterminado']]);
                echo $this->Form->control('nivel', ['label' => ['text' => 'Nivel de estagio'], 'options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '9' => 'Extra-curricular']]);
            }

            echo $this->Form->control('tc', ['label' => ['text' => 'Termo de compromisso'], 'options' => [0 => "Nao", 1 => "Sim"]]);
            echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data de solicitaçao do TC'], 'empty' => true, 'value' => new DateTime()]);

            if (isset($estudante_id)) {
                echo $this->Form->control('instituicaoestagio_id', ['label' => ['text' => 'Instituicao de estagio'], 'options' => $instituicaoestagios, 'value' => $estudantedeestagio->instituicaoestagio_id]);
                echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'value' => $estudantedeestagio->supervisor_id]);
                echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor(a) de OTP'], 'options' => $docentes, 'value' => $estudantedeestagio->professor_id]);
            } else {
                echo $this->Form->control('instituicaoestagio_id', ['label' => ['text' => 'Instituicao de estagio'], 'options' => $instituicaoestagios, 'empty' => "Seleciona"]);
                echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => "Seleciona"]);
                echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor(a) de OTP'], 'options' => $docentes, 'empty' => "Seleciona"]);
            }
            echo $this->Form->control('periodo', ['value' => $periodo]);
            echo $this->Form->control('turmaestagio_id', ['label' => ['text' => 'Turma de estagio'], 'options' => $turmaestagios, 'empty' => "Seleciona"]);
            echo $this->Form->control('nota');
            echo $this->Form->control('ch', ['label' => ['text' => 'Carga horaria']]);
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Outras informacoes']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>