<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
?>

<?= $this->element('templates') ?>

<div class='container'>
    <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
    <?=
        $this->Form->postLink(
            __('Excluir'),
            ['action' => 'delete', $instituicaoestagio->id],
            ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $instituicaoestagio->id), 'class' => 'btn btn-danger float-end']
        )
        ?>

    <div class="container">
        <?= $this->Form->create($instituicaoestagio) ?>
        <fieldset>
            <legend><?= __('Editar instituição') ?></legend>
            <?php
            echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituiçõa']]);
            echo $this->Form->control('areainstituicoes_id', ['label' => ['text' => 'Área de instituições'] ,'options' => $areainstituicoes, 'empty' => true]);
            echo $this->Form->control('area', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => true]);
            echo $this->Form->control('natureza');
            echo $this->Form->control('cnpj', ['label' => ['text' => 'CNPJ']]);
            echo $this->Form->control('email');
            echo $this->Form->control('url', ['label' => ['text' => 'Página web']]);
            echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
            echo $this->Form->control('bairro');
            echo $this->Form->control('municipio');
            echo $this->Form->control('cep', ['label' => ['text' => 'CEP']]);
            echo $this->Form->control('telefone');
            echo $this->Form->control('fax');
            echo $this->Form->control('beneficio', ['label' => ['text' => 'Benefícios para os estagiários']]);
            echo $this->Form->control('fim_de_semana', ['label' => ['text' => 'Estágio no final de semana?']]);
            echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local de inscrição para estágio']]);
            echo $this->Form->control('convenio', ['label' => ['text' => 'Número de convênio'], 'default' => 0]);
            echo $this->Form->control('expira', ['label' => ['text' => 'Data de expiração do convênio'], 'empty' => true]);
            echo $this->Form->control('seguro', ['label' => ['text' => 'Oferece seguro para os estagiários?'] ,'options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('avaliacao');
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Outras informações']]);
            echo $this->Form->control('supervisores._ids', ['options' => $supervisores]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>