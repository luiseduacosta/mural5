<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('observacoes')
</script>

<?= $this->element('templates') ?>

<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?=
                    $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $estagiario->id],
                        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-end']
                    )
                    ?>
                <?= $this->Html->link(__('Listar Estagiários'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="estagiarios form content">
                <?= $this->Form->create($estagiario) ?>
                <fieldset>
                    <legend><?= __('Editar Estagiário') ?></legend>
                    <?php
                    echo $this->Form->control('id_aluno', ['label' => ['text' => 'Aluno(a)'], 'options' => $alunos]);
                    echo $this->Form->control('alunonovo_id', ['label' => ['text' => 'Estudante'], 'options' => $estudantes]);
                    echo $this->Form->control('registro');
                    echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                    echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
                    echo $this->Form->control('nivel');
                    echo $this->Form->control('tc');
                    echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data TC']]);
                    echo $this->Form->control('id_instituicao', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios, 'empty' => true]);
                    echo $this->Form->control('id_supervisor', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => true]);
                    echo $this->Form->control('id_professor', ['label' => ['text' => 'Professor(a)'], 'options' => $docentes, 'empty' => true]);
                    echo $this->Form->control('periodo', ['label' => ['text' => 'Período']]);
                    echo $this->Form->control('id_area', ['label' => ['text' => 'Área'], 'options' => $turmaestagios, 'empty' => true]);
                    echo $this->Form->control('nota');
                    echo $this->Form->control('ch', ['label' => ['text' => 'CH']]);
                    echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'name' => 'observacoes', 'class' => 'form-control']);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>