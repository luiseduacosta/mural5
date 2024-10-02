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
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $turmaestagio->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
            <?= $this->Html->link(__('Listar turma de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="turmaestagios form content">
            <?= $this->Form->create($turmaestagio) ?>
            <fieldset>
                <legend><?= __('Editar turma de estágio') ?></legend>
                <?php
                echo $this->Form->control('area', ['label' => ['text' => 'Turma']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>