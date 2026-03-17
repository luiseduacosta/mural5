<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
$categoria = $this->getRequest()->getAttribute('identity')['categoria'];
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
        <li class="nav-item">
            <?php if (isset($categoria) && $categoria == 1): ?>
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $muralestagio->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralestagio->id), 'class' => 'btn btn-danger']
                )
                ?>
        </li>
    </ul>
</nav>

    <div class="row">
        <div class="container">
            <?= $this->element('templates') ?>
            <?= $this->Form->create($muralestagio) ?>
            <fieldset>
                <legend><?= __('Editar Mural') ?></legend>
                <?php
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'empty' => true, 'readonly']);
                echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                echo $this->Form->control('vagas');
                echo $this->Form->control('beneficios', ['label' => ['text' => 'Benefícios']]);
                echo $this->Form->control('final_de_semana', ['label' => ['text' => 'Final de semana'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                echo $this->Form->control('cargaHoraria', ['label' => ['text' => 'Carga horária']]);
                echo $this->Form->control('requisitos');
                echo $this->Form->control('turmaestagio_id', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => true]);
                echo $this->Form->control('horario', ['label' => ['text' => 'Horário da OTP'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
                echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor da OTP'], 'options' => $professores, 'empty' => true]);
                echo $this->Form->control('dataSelecao', ['label' => ['text' => 'Data da seleção'], 'empty' => true]);
                echo $this->Form->control('dataInscricao', ['label' => ['text' => 'Encerramento das inscrições'], 'empty' => true]);
                echo $this->Form->control('horarioSelecao', ['label' => ['text' => 'Horário da seleção']]);
                echo $this->Form->control('localSelecao', ['label' => ['text' => 'Local da seleção']]);
                echo $this->Form->control('formaSelecao', ['label' => ['text' => 'Forma da seleção'], 'options' => ['0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras']]);
                echo $this->Form->control('contato');
                echo $this->Form->control('email');
                echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'options' => $periodostotal]);
                echo $this->Form->control('datafax', ['empty' => true]);
                echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local da inscrição'], 'options' => ['0' => 'Somente no mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição e na Coordenação de Estágio/ESS']]);
                echo $this->Form->control('outras', ['label' => ['text' => 'Outras informações']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Strikethrough,
        Font,
        Paragraph,
        List,
        Alignment
    } from 'ckeditor5';

    let requisitos;
    if (typeof requisitos !== 'undefined') {
        requisitos.destroy();
    }

    ClassicEditor
        .create(document.querySelector('#muralestagioRequisitos'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'list', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            requisitos = editor;
            console.log('Olá editor muralestagioOutras was initialized', requisitos);
            requisitos.setData("");
        });



    let outras;
    if (typeof outras !== 'undefined') {
        outras.destroy();
    }

    ClassicEditor
        .create(document.querySelector('#muralestagioOutras'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'list', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            outras = editor;
            console.log('Olá editor muralestagioOutras was initialized', outras);
            outras.setData("");
        });

</script>