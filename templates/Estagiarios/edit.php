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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?=
                        $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $estagiario->id],
                            ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-end']
                        )
                        ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Estagiários'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($estagiario) ?>
        <fieldset>
            <legend><?= __('Editar Estagiário') ?></legend>
            <?php
            echo $this->Form->control('estudante_id', ['label' => ['text' => 'Estudante'], 'options' => $estudantes]);
            echo $this->Form->control('registro');
            echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
            echo $this->Form->control('nivel');
            echo $this->Form->control('tc');
            echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data TC']]);
            echo $this->Form->control('instituicaoestagio_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicaoestagios, 'empty' => true]);
            echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => true]);
            echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor(a)'], 'options' => $professores, 'empty' => true]);
            echo $this->Form->control('periodo', ['label' => ['text' => 'Período']]);
            echo $this->Form->control('turmaestagio_id', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => true]);
            echo $this->Form->control('nota');
            echo $this->Form->control('ch', ['label' => ['text' => 'Carga horária']]);
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'name' => 'observacoes', 'class' => 'form-control']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>