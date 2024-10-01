<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
?>
<?= $this->element('templates') ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Listar configuracao'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="configuracao form content">
            <?= $this->Form->create($configuracao) ?>
            <fieldset>
                <legend><?= __('Configuração') ?></legend>
                <?php
                echo $this->Form->control('mural_periodo_atual');
                echo $this->Form->control('termo_compromisso_periodo');
                echo $this->Form->control('termo_compromisso_inicio');
                echo $this->Form->control('termo_compromisso_final');
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
