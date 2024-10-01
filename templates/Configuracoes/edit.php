<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
?>
<?= $this->element('templates') ?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?= $this->Html->link(__('Listar configuração'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="configuracao form content">
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
    </div>
</div>