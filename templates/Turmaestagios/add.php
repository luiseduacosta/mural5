<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
?>
<?= $this->element('templates') ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Listar turmas de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="turmaestagios form content">
            <?= $this->Form->create($turmaestagio) ?>
            <fieldset>
                <legend><?= __('Nova turma de estágio') ?></legend>
                <?php
                echo $this->Form->control('area', ['label' => ['text' => 'Turma']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
