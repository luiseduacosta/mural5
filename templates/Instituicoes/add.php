<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicao
 */
// pr($instituicao);
// die();
?>

<?= $this->element('templates') ?>

<div class='container'>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar instituições de estágio'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="table-responsive">
        <?= $this->Form->create($instituicao) ?>
        <fieldset>
            <legend><?= __('Nova instituição de estágio') ?></legend>
            <?php
            echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição']]);
            echo $this->Form->control('area_id', ['label' => ['text' => 'Área da instituição'], 'options' => $areas, 'empty' => true]);
            echo $this->Form->control('area', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => true]);
            echo $this->Form->control('natureza', ['label' => ['text' => 'Natureza']]);
            echo $this->Form->control('cnpj', ['label' => ['text' => 'CNPJ']]);
            echo $this->Form->control('email');
            echo $this->Form->control('url', ['label' => ['text' => 'Endereço na Internet']]);
            echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
            echo $this->Form->control('bairro');
            echo $this->Form->control('municipio');
            echo $this->Form->control('cep');
            echo $this->Form->control('telefone');
            echo $this->Form->control('fax', ['type' => 'hidden']);
            echo $this->Form->control('beneficio', ['label' => ['text' => 'Benefícios (digitar por extenso)']]);
            echo $this->Form->control('fim_de_semana', ['label' => ['text' => 'Estágio no final de semana?'], 'options' => ['0' => 'Não', '1' => 'Sim', '3' => 'Parcialmente']]);
            echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local de inscrição para estágio']]);
            echo $this->Form->control('convenio', ['label' => ['text' => 'Número do convênio com a UFRJ'], 'default' => 0]);
            echo $this->Form->control('expira', ['label' => ['text' => 'Data de expiração do convênio'], 'empty' => true]);
            echo $this->Form->control('seguro', ['label' => ['text' => 'Oferece seguro para os estagiários?'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('avaliacao', ['type' => 'hidden']);
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
            echo $this->Form->control('supervisores._ids', ['options' => $supervisores, 'empty' => true]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>