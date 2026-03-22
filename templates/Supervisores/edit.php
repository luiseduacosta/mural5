<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>

<<<<<<< HEAD
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">

                    <?= $this->Html->link(__('Listar supervisores'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <?php if ($user->categoria == 1): ?>
                    <li class="nav-item">
                        <?=
                            $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $supervisor->id],
                                ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $supervisor->id), 'class' => 'btn btn-danger float-end']
                            )
                            ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
=======
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#cpf').mask('000.000.000-00');

        if ($('#ddd_telefone').val() === '' ) {
            codigo = '21';
        } else {
            codigo = $('#ddd_telefone').val();
        }
        if ($('#telefone').val().length >= 8 && $('#telefone').val().length <= 10) {
            $('#telefone').val('(' + codigo + ') ' + $('#telefone').val());
        }
        var telMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-0000';
        };
        var telOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(telMaskBehavior.apply({}, arguments), options);
            },
            clearIfNotMatch: true
        };
        $('#telefone').mask(telMaskBehavior, telOptions);

                if ($('#ddd_celular').val() === '' ) {
            codigo = '21';
        } else {
            codigo = $('#ddd_celular').val();
        }
        if ($('#celular').val().length >= 8 && $('#celular').val().length <= 10) {
            $('#celular').val('(' + codigo + ') ' + $('#celular').val());
        }
        var celMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-0000';
        };
        var celOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(celMaskBehavior.apply({}, arguments), options);
            },
            clearIfNotMatch: true
        };
        $('#celular').mask(celMaskBehavior, celOptions);

        $('#cep').mask('00000-000');
    });
</script>

<?php echo $this->element("menu_mural"); ?>
>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerSupervisores"
            aria-controls="navbarTogglerSupervisores" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerSupervisores">
        <li class="nav-item">
            <?= $this->Html->link(
                __("Listar supervisores"),
                ["action" => "index"],
                ["class" => "btn btn-primary me-1"],
            ) ?>
        </li>
        <li class="nav-item">
            <?php if (isset($user) && $user->categoria == "1"): ?>
                <?= $this->Form->postLink(
                    __("Excluir"),
                    ["action" => "delete", $supervisor->id],
                    [
                        "confirm" => __(
                            "Tem certeza que deseja excluir este registo # {0}?",
                            $supervisor->id,
                        ),
                        "class" => "btn btn-danger",
                    ],
                ) ?>
            <?php endif; ?>
        </li>
    </ul>
</nav>

<?php echo $this->element("templates"); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($supervisor, [
        "url" => ["action" => "edit", $supervisor->id],
        "class" => "form-inline",
    ]) ?>
    <fieldset>
        <legend><?= __("Editar Supervisor(a)") ?></legend>
        <?php
        echo $this->Form->control("nome", [
            "label" => "Nome",
            "type" => "text",
            "class" => "form-control",
        ]);
        echo $this->Form->control("cpf", ["label" => "CPF", "type" => "text"]);
        echo $this->Form->control("cress", [
            "label" => "CRESS",
            "type" => "number",
        ]);
        echo $this->Form->control("regiao", [
            "label" => "Região",
            "type" => "number",
        ]);
        echo $this->Form->control("cep", ["label" => "CEP", "type" => "text"]);
        echo $this->Form->control("endereco", [
            "label" => "Endereço",
            "type" => "text",
        ]);
        echo $this->Form->control("bairro", [
            "label" => "Bairro",
            "type" => "text",
        ]);
        echo $this->Form->control("municipio", [
            "label" => "Município",
            "type" => "text",
        ]);
        echo $this->Form->control("codigo_tel", [
            "label" => "DDD",
            "type" => "number",
        ]);
        echo $this->Form->control("telefone", [
            "label" => "Telefone",
            "type" => "text",
        ]);
        echo $this->Form->control("codigo_cel", [
            "label" => "DDD",
            "type" => "number",
        ]);
        echo $this->Form->control("celular", [
            "label" => "Celular",
            "type" => "text",
        ]);
        echo $this->Form->control("email", [
            "label" => "E-mail",
            "type" => "email",
        ]);
        echo $this->Form->control("escola", [
            "label" => "Escola de origem",
            "type" => "text",
        ]);
        echo $this->Form->control("ano_formatura", [
            "label" => "Ano de formatura",
            "type" => "number",
        ]);
        echo $this->Form->control("outros_estudos", [
            "label" => "Outros estudos",
            "type" => "text",
        ]);
        echo $this->Form->control("area_curso", [
            "label" => "Área do curso",
            "type" => "text",
        ]);
        echo $this->Form->control("ano_curso", [
            "label" => "Ano do curso",
            "type" => "number",
        ]);
        echo $this->Form->control("cargo", [
            "label" => "Cargo que ocupa",
            "type" => "text",
        ]);
        echo $this->Form->control("num_inscricao", [
            "label" => "Inscrição para curso de supervisores",
            "type" => "number",
        ]);
        echo $this->Form->control("curso_turma", [
            "label" => "Turma do curso de supervisores",
            "type" => "number",
        ]);
        echo $this->Form->control("observacoes", [
            "label" => "Observações",
            "type" => "textarea",
            "class" => "form-control",
            "rows" => "5",
        ]);
        echo $this->Form->control("instituicoes._ids", [
            "label" => "Instituição",
            "options" => $instituicoes,
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__("Salvar"), ["class" => "btn btn-primary"]) ?>
    <?= $this->Form->end() ?>
</div>
