<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#cpf').mask('000.000.000-00');

        if ($('#codigo_telefone').val() === '' ) {
            codigo = '21';
        } else {
            codigo = $('#codigo_telefone').val();
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

        if ($('#codigo_celular').val() === '' ) {
            codigo = '21';
        } else {
            codigo = $('#codigo_celular').val();
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

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <li class="nav-item">
            <?= $this->Html->link(
                __("Listar supervisores"),
                ["action" => "index"],
                ["class" => "btn btn-primary me-1", "style" => "font-size: 10pt;"],
            ) ?>
        </li>
        <li class="nav-item">
            <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
                <?= $this->Form->postLink(
                    __("Excluir"),
                    ["action" => "delete", $supervisor->id],
                    [
                        "confirm" => __(
                            "Tem certeza que deseja excluir este registo # {0}?",
                            $supervisor->id,
                        ),
                        "class" => "btn btn-danger me-1", "style" => "font-size: 10pt;",
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
        echo $this->Form->control("codigo_telefone", [
            "label" => "DDD",
            "type" => "number",
        ]);
        echo $this->Form->control("telefone", [
            "label" => "Telefone",
            "type" => "text",
        ]);
        echo $this->Form->control("codigo_celular", [
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
        echo $this->Form->control("cargo", [
            "label" => "Cargo que ocupa",
            "type" => "text",
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
