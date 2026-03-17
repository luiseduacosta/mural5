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
                    <?= $this->Html->link(__('Listar configuracao'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($configuracao) ?>
        <fieldset>
            <legend><?= __('Configuração') ?></legend>
            <?php
            echo $this->Form->control('mural_periodo_atual', ['label' => 'Período atual do mural']);
            echo $this->Form->control('termo_compromisso_periodo', ['label' => 'Período do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_inicio', ['label' => 'Início do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_final', ['label' => 'Fim do termo de compromisso']);
            echo $this->Form->control('curso_turma_atual', ['label' => 'Turma atual do curso']);
            echo $this->Form->control('curso_abertura_inscricoes', ['label' => 'Abertura das inscrições do curso']);
            echo $this->Form->control('curso_encerramento_inscricoes', ['label' => 'Encerramento das inscrições do curso']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>