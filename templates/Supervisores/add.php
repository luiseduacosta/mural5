<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>
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
            </ul>
        </div>
    </nav>

<?php $this->element("templates"); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($supervisor) ?>
    <fieldset>
        <legend><?= __("Nova supervisora") ?></legend>
        <?php
        echo $this->Form->control("nome", [
            "label" => ["text" => "Nome"],
            "type" => "text",
        ]);
        echo $this->Form->control("cpf", [
            "label" => ["text" => "CPF"],
            "type" => "text",
            "mask" => "000.000.000-00",
            "placeholder" => "000.000.000-00",
        ]);
        echo $this->Form->control("endereco", [
            "label" => ["text" => "Endereço"],
            "type" => "text",
            "placeholder" => "Endereço",
        ]);
        echo $this->Form->control("bairro", [
            "label" => ["text" => "Bairro"],
            "type" => "text",
            "placeholder" => "Bairro",
        ]);
        echo $this->Form->control("municipio", [
            "label" => ["text" => "Município"],
            "type" => "text",
            "placeholder" => "Município",
        ]);
        echo $this->Form->control("cep", [
            "label" => ["text" => "CEP"],
            "type" => "text",
            "mask" => "00000-000",
            "placeholder" => "00000-000",
        ]);
        echo $this->Form->control("codigo_tel", [
            "label" => ["text" => "DDD"],
            "type" => "number",
        ]);
        echo $this->Form->control("telefone", [
            "label" => ["text" => "Telefone"],
            "type" => "text",
            "mask" => "(00) 0000-0000",
            "placeholder" => "(00) 0000-0000",
        ]);
        echo $this->Form->control("codigo_cel", [
            "label" => ["text" => "DDD"],
            "type" => "number",
        ]);
        echo $this->Form->control("celular", [
            "label" => ["text" => "Celular"],
            "type" => "text",
            "mask" => "(00) 00000-0000",
            "placeholder" => "(00) 00000-0000",
        ]);
        if (isset($email)) {
            echo $this->Form->control("email", [
                "label" => ["text" => "E-mail"],
                "type" => "email",
                "value" => $email,
                "readonly" => true,
            ]);
        } else {
            echo $this->Form->control("email", [
                "label" => ["text" => "E-mail"],
                "type" => "email",
            ]);
        }
        echo $this->Form->control("escola", [
            "label" => ["text" => "Escola de origem"],
            "type" => "text",
        ]);
        echo $this->Form->control("ano_formatura", [
            "label" => ["text" => "Ano de formatura"],
            "type" => "number",
            "mask" => "0000",
            "placeholder" => "0000",
        ]);
        if (isset($cress)) {
            echo $this->Form->control("cress", [
                "label" => ["text" => "Cress"],
                "type" => "number",
                "value" => $cress,
                "readonly" => true,
            ]);
        } else {
            echo $this->Form->control("cress", [
                "label" => ["text" => "Cress"],
                "type" => "number",
            ]);
        }
        echo $this->Form->control("regiao", [
            "label" => ["text" => "Região"],
            "type" => "number",
            "value" => 7,
        ]);
        echo $this->Form->control("outros_estudos", [
            "label" => ["text" => "Outros estudos"],
            "type" => "text",
        ]);
        echo $this->Form->control("area_curso", [
            "label" => ["text" => "Área do curso"],
            "type" => "text",
        ]);
        echo $this->Form->control("ano_curso", [
            "label" => ["text" => "Ano do curso"],
            "type" => "number",
            "mask" => "0000",
            "placeholder" => "0000",
        ]);
        echo $this->Form->control("cargo", [
            "label" => ["text" => "Cargo que ocupa"],
            "type" => "text",
        ]);
        echo $this->Form->control("num_inscricao", [
            "label" => [
                "text" => "Número de inscrição para o curso de supervisores",
            ],
            "type" => "number",
        ]);
        echo $this->Form->control("curso_turma", [
            "label" => ["text" => "Turma do curso de supervisores"],
            "type" => "number",
        ]);
        echo $this->Form->control("observacoes", [
            "label" => ["text" => "Observações"],
            "type" => "textarea",
        ]);
        echo $this->Form->control("instituicoes._ids", [
            "label" => ["text" => "Instituição"],
            "options" => $instituicoes,
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__("Confirma", ["class" => "btn btn-primary"])) ?>
    <?= $this->Form->end() ?>
</div>
