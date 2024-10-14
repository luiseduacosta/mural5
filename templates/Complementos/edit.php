<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
?>
<?= $this->element('templates') ?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $complemento->id],
                        ['confirm' => __('Tem certeza que quer excluir # {0}?', $complemento->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
                <?= $this->Html->link(__('Listar complemento do estágio'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="complementos form content">
                <?= $this->Form->create($complemento) ?>
                <fieldset>
                    <legend><?= __('Editar complemento de estágio') ?></legend>
                    <?php
                    echo $this->Form->control('periodo_especial');
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>