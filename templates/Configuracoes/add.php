<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar configurações'), ['action' => 'index'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($configuracao) ?>
        <fieldset>
            <legend><?= __('Configuração') ?></legend>
            <?php
            echo $this->Form->control('instituicao_nome', ['label' => 'Nome da instituição']);
            echo $this->Form->control('mural_periodo_atual', ['label' => 'Período atual do mural']);
            echo $this->Form->control('termo_compromisso_periodo', ['label' => 'Período do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_inicio', ['label' => 'Início do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_final', ['label' => 'Fim do termo de compromisso']);
            echo $this->Form->control('curso_turma_atual', ['label' => 'Turma atual do curso']);
            echo $this->Form->control('curso_abertura_inscricoes', ['label' => 'Abertura das inscrições do curso']);
            echo $this->Form->control('curso_encerramento_inscricoes', ['label' => 'Encerramento das inscrições do curso']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
</div>
