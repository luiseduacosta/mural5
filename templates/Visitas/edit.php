<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
?>

<?= $this->element('templates') ?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $visita->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $visita->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
            <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="container">
        <?= $this->Form->create($visita) ?>
        <fieldset>
            <legend><?= __('Editar visita') ?></legend>
            <?php
            echo $this->Form->control('instituicaoestagio_id', ['options' => $instituicaoestagios]);
            echo $this->Form->control('data');
            echo $this->Form->control('motivo');
            echo $this->Form->control('responsavel');
            echo $this->Form->control('descricao');
            echo $this->Form->control('avaliacao');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>