<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('observacoes')
</script>

<?= $this->element('templates') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav ms-auto mt-lg-0">
            <li class="nav-item">
                <?= $this->Html->link(__('Voltar'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
            </li>
            <?php
            if ($user_data['categoria'] == '1') {
                ?>
                <li class="nav-item">
                    <?=
                        $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $estagiario->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger me-2', 'style' => 'font-size: 10pt;'])
                    ?>
                </li>
            <?php } ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar Estagiários'), ['action' => 'index'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <?= $this->Form->create($estagiario) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar Estagiário(a)') ?></legend>
        <?php

        if ($user_data['categoria'] == '2') {
            echo $this->Form->control('aluno_id', [
                'label' => ['text' => 'Aluno(a)'],
                'options' => $alunos,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);
            echo $this->Form->control('registro', ['label' => ['text' => 'DRE']]);
            echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim'],
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);
            echo $this->Form->control('nivel');

            echo $this->Form->control('tc_solicitacao', ['label' => ['text' => 'Data da solicitação do TC']]);

        } elseif ($user_data['categoria'] == '1') {

            echo $this->Form->control('tc', ['label' => ['text' => 'Termo de compromisso assinado'], 'options' => [0 => "Nao", 1 => "Sim"],
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);

            echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);

            echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);
           
            echo $this->Form->control('professor_id', ['label' => ['text' => 'Professor(a)'], 'options' => $professores, 'empty' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);

            echo $this->Form->control('periodo', ['label' => ['text' => 'Período']]);

            echo $this->Form->control('complemento_id', ['label' => ['text' => 'Tipo de estágio (Pandemia)'], 'options' => [1 => 'Remoto', 2 => 'Ple'], 'empty' => "Seleciona",
                'templates' => [
                  'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                ]
            ]);

        }
        // Professor pode lançar nota e carga horária
        if ($user_data['categoria'] == '1' || $user_data['categoria'] == '3') {

            echo $this->Form->control('nota');

            echo $this->Form->control('ch', ['label' => ['text' => 'Carga horária']]);

            echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'name' => 'observacoes', 'class' => 'form-control']);

        }

    ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>

<?php
$niveis = [
    '1' => '1º',
    '2' => '2º',
    '3' => '3º',
    '4' => '4º',
    '9' => 'Estágio extra-curricular',
];
?>

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
        .create(document.querySelector('#observacoes'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'bulletedList', 'numberedList', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            observacoes = editor;
            console.log('Olá editor observações inicializado', observacoes);
            requisitos.setData("");
        });

</script>