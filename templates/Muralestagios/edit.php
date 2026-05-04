<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary', 'style' => 'font-size: 10pt;']) ?>
        </li>
        <li class="nav-item">
            <?php if ($user_data['categoria'] === '1'): ?>
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $muralestagio->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralestagio->id), 'class' => 'btn btn-danger', 'style' => 'font-size: 10pt;']
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
                echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'empty' => true, 'readonly', 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]]);
                echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'options' => ['0' => 'Não', '1' => 'Sim'], 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]]);
                echo $this->Form->control('beneficios', ['label' => ['text' => 'Benefícios'], 'empty' => true]);
                echo $this->Form->control('final_de_semana', ['label' => ['text' => 'Final de semana'], 'options' => ['0' => 'Não', '1' => 'Sim'], 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]]);
                echo $this->Form->control('horario', ['label' => ['text' => 'Horário da OTP'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado'], 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]]);
                echo $this->Form->control('data_selecao', ['label' => ['text' => 'Data da seleção'], 'empty' => true]);
                echo $this->Form->control('data_inscricao', ['label' => ['text' => 'Encerramento das inscrições'], 'empty' => true]);
                echo $this->Form->control('horario_selecao', ['label' => ['text' => 'Horário da seleção'], 'empty' => true]);
                echo $this->Form->control('local_selecao', ['label' => ['text' => 'Local da seleção'], 'empty' => true]);
                echo $this->Form->control('forma_selecao', ['label' => ['text' => 'Forma da seleção'], 'options' => ['0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras'], 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]]);
                echo $this->Form->control('contato', ['label' => ['text' => 'Contato'], 'empty' => true]);
                echo $this->Form->control('email', ['label' => ['text' => 'Email'], 'empty' => true]);
                echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'type' => 'text', 'empty' => true]);
                echo $this->Form->control('local_inscricao', ['label' => ['text' => 'Local da inscrição'], 'options' => ['0' => 'Somente no mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição e na Coordenação de Estágio/ESS'], 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]]);
                echo $this->Form->control('outras', ['label' => ['text' => 'Outras informações'], 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
<?php endif; ?>

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
