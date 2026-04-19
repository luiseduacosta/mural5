<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- jQuery Mask -->
<script>
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00');
        $('#cep').mask('00000-000');

        if ($('#codigo_telefone').val() === '' ) {
            codigo = '21';
        } else {
            codigo = $('#codigo_telefone').val();
        }
        if ($('#telefone').val().length >= 8 && $('#telefone').val().length <= 10) {
            $('#telefone').val('(' + codigo + ') ' + $('#telefone').val());
        }
        var telMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000.0000' : '(00) 0000.00009';
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
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000.0000' : '(00) 0000.00009';
        };
        var celOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(celMaskBehavior.apply({}, arguments), options);
            },
            clearIfNotMatch: true
        };
        $('#celular').mask(celMaskBehavior, celOptions);

    });
</script>

<?= $this->element('templates') ?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Professore(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($professor) ?>
    <fieldset>
        <legend><?= __('Novo(a) professor(a)') ?></legend>
        <?php
        /** Dados pessoais */
        echo $this->Form->control('nome', ['label' => ['text' => 'Nome']]);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'pattern' => '\d{3}\.\d{3}\.\d{3}-\d{2}', 'keypress()', 'placeholder' => '000.000.000-00', 'required' => true]);
        /** Dados funcionais */
        if (isset($siape)) {
            echo $this->Form->control('siape', ['value' => $siape, 'readonly', 'label' => ['text' => 'SIAPE']]);
        } else {
            echo $this->Form->control('siape', ['required' => true, 'label' => ['text' => 'SIAPE']]);
        }
        echo $this->Form->control('dataingresso', ['empty' => true, 'label' => ['text' => 'Data de Ingresso na UFRJ/ESS']]);
        echo $this->Form->control('departamento', ['label' => ['text' => 'Departamento'], 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['empty' => true, 'label' => ['text' => 'Data de Egresso']]);
        echo $this->Form->control('motivoegresso', ['label' => ['text' => 'Motivo de Egresso'], 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro']]);
        /** Dados de contato */
        echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'DDD do Telefone']]);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone']]);
        echo $this->Form->control('codigo_celular', ['label' => ['text' => 'DDD do Celular']]);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular']]);
        if (isset($email)) {
            echo $this->Form->control('email', ['value' => $email, 'readonly', 'label' => ['text' => 'Email']]);
        } else {
            echo $this->Form->control('email', ['required' => true, 'label' => ['text' => 'Email']]);
        }
        /** Dados de currículos */
        echo $this->Form->control('curriculolattes', ['label' => ['text' => 'Currículo Lattes']]);
        echo $this->Form->control('atualizacaolattes', ['empty' => true, 'label' => ['text' => 'Atualização Lattes']]);
        /** Outras informações */
        echo $this->Form->control('observacoes', ['type' => 'textarea', 'rows' => '3', 'cols' => '40', 'label' => ['text' => 'Outras informações']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>