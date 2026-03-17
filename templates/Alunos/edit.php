<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
$usuario = $this->getRequest()->getAttribute('identity');
?>
<?= $this->element('templates') ?>
<div class='container'>

    <?php if ($usuario->get('categoria') == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Aluno(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $aluno->id],
                            ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $aluno->id), 'class' => 'btn btn-danger float-end']
                        )
                            ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __("Editar aluno(a)") ?></legend>
        <?php
        echo $this->Form->control("id", [
            "type" => "hidden",
        ]);
        echo $this->Form->control("nome", [
            "label" => "Nome",
            "class" => "form-control",
        ]);
        echo $this->Form->control("nomesocial", [
            "label" => "Nome social",
            "class" => "form-control",
        ]);
        echo $this->Form->control("registro", [
            "label" => "Registro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("ingresso", [
            'placeholder' => 'Ano e período de ingresso: ex: 2023-1',
            "label" => "Ingresso",
            "class" => "form-control",
        ]);
        echo $this->Form->control("turno", [
            'placeholder' => 'diurno, noturno ou outro',
            'options' => [
                'diurno' => 'Diurno',
                'noturno' => 'Noturno',
                'outro' => 'Outro',
            ],
            "label" => "Turno",
            "class" => "form-control",
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ],

        ]);
        echo $this->Form->control("nascimento", [
            'value' => $aluno->nascimento ? $aluno->nascimento->i18nFormat('dd-MM-yyyy') : '',
            'placeholder' => 'dd-MM-yyyy',
            'type' => 'text',
            'pattern' => '\d{2}-\d{2}-\d{4}',
            'title' => 'Formato: dd-MM-yyyy',
            "label" => "Data de nascimento",
            "empty" => true,
            "class" => "form-control",
        ]);
        echo $this->Form->control("cpf", [
            'placeholder' => 'Número do CPF: ex: 000.000.000-00',
            "label" => "CPF",
            "class" => "form-control",
        ]);
        echo $this->Form->control("identidade", [
            "label" => "RG",
            "class" => "form-control",
        ]);
        echo $this->Form->control("orgao", [
            "label" => "Orgão emissor",
            "class" => "form-control",
        ]);
        echo $this->Form->control("email", [
            "label" => "E-mail",
            "class" => "form-control",
        ]);
        echo $this->Form->control("codigo_telefone", [
            "label" => "DDD",
            "class" => "form-control",
        ]);
        echo $this->Form->control("telefone", [
            "label" => "Telefone",
            "class" => "form-control",
        ]);
        echo $this->Form->control("codigo_celular", [
            "label" => "DDD",
            "class" => "form-control",
        ]);
        echo $this->Form->control("celular", [
            "label" => "Celular",
            "class" => "form-control",
        ]);
        echo $this->Form->control("cep", [
            "label" => "CEP",
            "class" => "form-control",
        ]);
        echo $this->Form->control("endereco", [
            "label" => "Endereço",
            "class" => "form-control",
        ]);
        echo $this->Form->control("municipio", [
            "label" => "Município",
            "class" => "form-control",
        ]);
        echo $this->Form->control("bairro", [
            "label" => "Bairro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("observacoes", [
            "label" => "Observações",
            "class" => "form-control",
        ]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(
            __("Confirmar alterações"),
            ["class" => "btn btn-primary"],
        ) ?>
    </div>
    <?= $this->Form->end() ?>
</div>