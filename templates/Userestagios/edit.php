<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
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
                        ['action' => 'delete', $userestagio->id],
                        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $userestagio->id), 'class' => 'btn btn-danger float-end']
                    )
                    ?>
                <?= $this->Html->link(__('Listar usuário de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="container">
            <?= $this->Form->create($userestagio) ?>
            <fieldset>
                <legend><?= __('Editar  usuário') ?></legend>
                <?php
                echo $this->Form->control('email');
                echo $this->Form->control('password');
                echo $this->Form->control('categoria_id');
                echo $this->Form->control('registro');
                echo $this->Form->control('estudante_id', ['options' => $estudantes, 'empty' => true]);
                echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'empty' => true]);
                echo $this->Form->control('professor_id', ['options' => $docentes, 'empty' => true]);
                echo $this->Form->control('timestamp');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>