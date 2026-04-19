<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
?>

<!-- jQuery Mask -->
<script>
    $(document).ready(function () {
        $('#cnpj').mask('00.000.000/0000-00');
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });
</script>

<?php $this->element('templates') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerInstituicoes"
        aria-controls="navbarTogglerInstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerInstituicoes">
        <?php if (isset($categoria) && $categoria == '1'): ?>
            <li class="nav-item">
                <?=
                    $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $instituicao->id],
                        ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $instituicao->id), 'class' => 'btn btn-danger me-1']
                    )
                    ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($instituicao) ?>
    <fieldset>
        <legend><?= __('Editar instituição') ?></legend>
        <?php
        echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição'], 'required' => true]);
        echo $this->Form->control('area_id', ['label' => ['text' => 'Área da instituição'], 'options' => $areas, 'empty' => true, 'required' => false]);
        echo $this->Form->control('natureza', ['label' => ['text' => 'Natureza'], 'required' => false]);
        echo $this->Form->control('cnpj', ['label' => ['text' => 'CNPJ'], 'placeholder' => '00.000.000/0000-00', 'id' => 'cnpj', 'keypress()', 'required' => false]);
        echo $this->Form->control('email', ['label' => ['text' => 'Email'], 'required' => false]);
        echo $this->Form->control('url', ['label' => ['text' => 'Site'], 'required' => false]);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço'], 'required' => false]);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro'], 'required' => false]);
        echo $this->Form->control('municipio', ['label' => ['text' => 'Município'], 'required' => false]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'id' => 'cep', 'required' => false, 'keypress()']);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone'], 'id' => 'telefone', 'required' => false, 'keypress()']);
        echo $this->Form->control('beneficio', ['label' => ['text' => 'Benefícios'], 'required' => false]);
        echo $this->Form->control('fim_de_semana', ['label' => ['text' => 'Estágio no final de semana?'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'required' => false]);
        echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local de inscrição'], 'placeholder' => 'Local de inscrição', 'required' => false]);
        echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'placeholder' => 'Número do convênio registrado na PR4', 'required' => false]);
        echo $this->Form->control('expira', ['label' => ['text' => 'Data de encerramento do convênio'], 'empty' => true, 'required' => false]);
        echo $this->Form->control('seguro', ['label' => ['text' => 'Seguro'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'required' => false]);
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'required' => false]);
        echo $this->Form->control('supervisores._ids', ['label' => ['text' => 'Supervisores'], 'options' => $supervisores, 'empty' => true, 'class' => 'form-control', 'required' => false]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-end">
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>