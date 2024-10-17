<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
?>

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/translations/pt.js"></script>

<script>

    $(document).ready(function () {

        ClassicEditor
            .create(document.querySelector('#requisitos'), {
                // The language code is defined in the https://en.wikipedia.org/wiki/ISO_639-1 standard.
                language: 'pt'
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#outras'), {
                language: 'pt'
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    });
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
                    <?= $this->Html->link(__('Listar mural'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($muralestagio) ?>
        <fieldset>
            <legend><?= __('Novo mural de estágio') ?></legend>
            <?php
            echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'empty' => true]);
            echo $this->Form->control('instituicao', ['type' => 'hidden']);
            echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('vagas');
            echo $this->Form->control('beneficios', ['label' => ['text' => 'Benefícios']]);
            echo $this->Form->control('final_de_semana', ['label' => ['text' => 'Final de semana'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('cargaHoraria', ['label' => ['text' => 'Carga horária']]);
            echo $this->Form->control('requisitos');
            echo $this->Form->control('turmaestagio_id', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => [0 => 'Seleciona']]);
            echo $this->Form->control('horario', ['label' => ['text' => 'Horário da OTP'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
            echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor da OTP'], 'options' => $professores, 'empty' => [0 => 'Seleciona']]);
            echo $this->Form->control('dataSelecao', ['label' => ['text' => 'Data da seleção'], 'empty' => true]);
            echo $this->Form->control('dataInscricao', ['label' => ['text' => 'Encerramento das inscrições'], 'empty' => true]);
            echo $this->Form->control('horarioSelecao', ['label' => ['text' => 'Horário da seleção']]);
            echo $this->Form->control('localSelecao', ['label' => ['text' => 'Local da seleção']]);
            echo $this->Form->control('formaSelecao', ['label' => ['text' => 'Forma de seleção'], 'options' => ['0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras']]);
            echo $this->Form->control('contato', ['label' => ['text' => 'Contato']]);
            echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
            echo $this->Form->control('datafax', ['type' => 'hidden', 'empty' => true]);
            echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local da inscrição'], 'options' => ['0' => 'Somente no mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição e no mural da Coordenação de Estágio/ESS']]);
            echo $this->Form->control('email');
            echo $this->Form->control('outras', ['label' => ['text' => 'Outras informações', 'class' => 'col-2 ckeditor']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>