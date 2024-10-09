<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicao
 */
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
                    <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?=
                        $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $instituicao->id],
                            ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $instituicao->id), 'class' => 'btn btn-danger float-end']
                        )
                        ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($instituicao) ?>
        <fieldset>
            <legend><?= __('Editar instituição') ?></legend>
            <?php
            echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituiçõa']]);
            echo $this->Form->control('area_id', ['label' => ['text' => 'Área de instituições'], 'options' => $areas, 'empty' => true]);
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
            echo $this->Form->control('seguro', ['label' => ['text' => 'Oferece seguro para os estagiários?'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
            echo $this->Form->control('avaliacao');
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Outras informações']]);
            echo $this->Form->control('supervisores._ids', ['options' => $supervisores]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>