<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar supervisores'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <?php if (isset($categoria) && $categoria == 1): ?>
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
