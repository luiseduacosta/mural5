<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
// pr($inscricao);
?>

<?= $this->element('templates') ?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $inscricao->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="container">
        <?= $this->Form->create($inscricao) ?>
        <fieldset>
            <legend><?= __('Editar Inscricao') ?></legend>
            <?php
            echo $this->Form->control('registro', ['value' => $inscricao->registro, 'readonly']);
            echo $this->Form->control('estudante_id', ['options' => [$inscricao->estudante_id => $inscricao->estudante->nome], 'empty' => $inscricao->estudante->nome, 'readonly']);
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