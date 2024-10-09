<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
?>
<?= $this->element('templates') ?>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar configuração'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($configuracao) ?>
        <fieldset>
            <legend><?= __('Editar configurações') ?></legend>
            <?php
            echo $this->Form->control('mural_periodo_atual', ['label' => ['text' => 'Período do mural de estágios']]);
            echo $this->Form->control('termo_compromisso_periodo', ['label' => ['text' => 'Período do termo de compromisso']]);
            echo $this->Form->control('termo_compromisso_inicio', ['label' => ['text' => 'Data de início do termo de compromisso']]);
            echo $this->Form->control('termo_compromisso_final', ['label' => ['text' => 'Data de finalização do termo de compromisso']]);
            echo $this->Form->control('curso_turma_atual');
            echo $this->Form->control('curso_abertura_inscricoes');
            echo $this->Form->control('curso_encerramento_inscricoes');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>