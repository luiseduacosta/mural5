<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
// pr($instituicaoestagio);
// die();
?>

<?= $this->element('templates') ?>

<div class='container'>
    <?= $this->Html->link(__('Listar instituições de estágio'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
    <div class="table-responsive">
        <?= $this->Form->create($instituicaoestagio) ?>
        <fieldset>
            <legend><?= __('Nova instituição de estágio') ?></legend>
            <?php
            echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição']]);
            echo $this->Form->control('areainstituicoes_id', ['label' => ['text' => 'Área da instituição'], 'options' => $areainstituicoes, 'empty' => true]);
            echo $this->Form->control('area', ['label' => ['text' => 'Área de estágio'], 'options' => $areaestagios, 'empty' => true]);
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
            echo $this->Form->control('localInscricao');
            echo $this->Form->control('convenio', ['label' => ['text' => 'Número do convênio com a UFRJ'], 'default' => 0]);
            echo $this->Form->control('expira', ['label' => ['text' => 'Data de expiração do convênio'], 'empty' => true]);
            echo $this->Form->control('seguro', ['options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('avaliacao', ['type' => 'hidden']);
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
            echo $this->Form->control('supervisores._ids', ['options' => $supervisores, 'empty' => true]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>