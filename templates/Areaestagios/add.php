<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
?>
<?= $this->element('templates') ?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Listar área de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areaestagios form content">
            <?= $this->Form->create($areaestagio) ?>
            <fieldset>
                <legend><?= __('Nova área de estágio') ?></legend>
                <?php
                echo $this->Form->control('area', ['label' => ['text' => 'Área']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
