<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
// pr($muralinscricao);
?>

<?= $this->element('templates') ?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $muralinscricao->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="container">
        <?= $this->Form->create($muralinscricao) ?>
        <fieldset>
            <legend><?= __('Editar Muralinscricao') ?></legend>
            <?php
            echo $this->Form->control('registro', ['value' => $muralinscricao->estudante->registro, 'readonly']);
            echo $this->Form->control('estudante_id', ['options' => [$muralinscricao->estudante->id => $muralinscricao->estudante->nome], 'empty' => $muralinscricao->estudante->nome, 'readonly']);
            echo $this->Form->control('muralestagio_id', ['options' => $muralestagios]);
            echo $this->Form->control('data');
            echo $this->Form->control('periodo');
            echo $this->Form->control('timestamp');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>