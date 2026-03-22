<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

    <div class="container">
        <?= $this->Form->create($configuracao) ?>
        <fieldset>
            <legend><?= __('Editar configurações') ?></legend>
            <?php
            echo $this->Form->control('mural_periodo_atual', ['label' => 'Período do mural de estágios']);
            echo $this->Form->control('termo_compromisso_periodo', ['label' => 'Período do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_inicio', ['label' => 'Data de início do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_final', ['label' => 'Data de finalização do termo de compromisso']);
            echo $this->Form->control('curso_turma_atual', ['label' => 'Turma atual do curso']);
            echo $this->Form->control('curso_abertura_inscricoes', ['label' => 'Abertura das inscrições do curso']);
            echo $this->Form->control('curso_encerramento_inscricoes', ['label' => 'Encerramento das inscrições do curso']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>