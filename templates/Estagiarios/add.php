<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>
<?= $this->element('templates') ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Listar estagiários'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="estagiarios form content">
            <?= $this->Form->create($estagiario) ?>
            <fieldset>
                <legend><?= __('Novo estagiário') ?></legend>
                <?php
                echo $this->Form->control('aluno_id', ['options' => $alunos]);
                echo $this->Form->control('estudante_id', ['options' => $estudantes, 'empty' => true]);
                echo $this->Form->control('registro');
                echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020']]);
                echo $this->Form->control('turno');
                echo $this->Form->control('nivel');
                echo $this->Form->control('tc');
                echo $this->Form->control('tc_solicitacao', ['empty' => true]);
                echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios]);
                echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
                echo $this->Form->control('docente_id', ['options' => $docentes, 'empty' => true]);
                echo $this->Form->control('periodo');
                echo $this->Form->control('areaestagio_id', ['options' => $areaestagios, 'empty' => true]);
                echo $this->Form->control('nota');
                echo $this->Form->control('ch');
                echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>