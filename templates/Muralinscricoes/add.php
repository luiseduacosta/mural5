<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
// pr($alunonovos);
// pr($alunoestagios);
// die();
$categoria = $this->getRequest()->getAttribute('identity')['categoria_id'];
// die();
?>

<?= $this->element('templates') ?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="container">
        <?= $this->Form->create($muralinscricao, ['method' => 'post']) ?>
        <fieldset>
            <legend><?= __('Inscrição para seleção de estágio') ?></legend>
            <?php
            if (isset($categoria) && $categoria == 1):
                echo $this->Form->control('estudante_id', ['label' => 'Estudante', 'options' => $estudantes, 'empty' => ['0' => 'Seleciona estudante']]);
                echo $this->Form->control('registro', ['type' => 'hidden']);
                echo $this->Form->control('muralestagio_id', ['label' => ['text'=> 'Mural de estágio'], 'options' => $muralestagios, 'value' => $muralestagio_id, 'empty' => ['0' => 'Seleciona instituição']]);
                echo $this->Form->control('data', ['value' => date('d-m-Y'), 'readonly']);
                echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo]);
                echo $this->Form->control('timestamp', ['type' => 'hidden']);
                echo $this->Form->control('aluno_id', ['type' => 'hidden']);
                // die(pr($categoria));
            elseif (isset($categoria) && $categoria == 2):
                echo $this->Form->control('estudante_id', ['label' => 'Estudante', 'options' => $estudantes, 'value' => $estudante_id, 'readonly']);
                echo $this->Form->control('muralestagio_id', ['label' => 'Mural de estágio', 'options' => $muralestagios, 'value' => $muralestagio_id, 'readonly']);
                echo $this->Form->control('data', ['type' => 'hidden', 'value' => date('Y-m-d'), 'readonly']);
                echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo, 'readonly']);
                echo $this->Form->control('timestamp', ['type' => 'hidden']);
                echo $this->Form->control('aluno_id', ['type' => 'hidden']);
            endif;
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>