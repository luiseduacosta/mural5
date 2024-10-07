<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
 */
?>

<?= $this->element('templates') ?>

<div class="container">
    <div class="row">
        <?php
        $user = $this->getRequest()->getAttribute('identity');
        if (isset($user) && $user->categoria_id == 1):
            ?>
            <?= $this->Html->link(__('Listar usuários do mural de estagios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        <?php endif;
        ?>
    </div>
    <div class="column-responsive column-80">
        <div class="userestagios form content">
            <?= $this->Form->create($userestagio) ?>
            <fieldset>
                <legend><?= __('Cadastro de novo usuário') ?></legend>
                <?php
                echo $this->Form->control('email');
                echo $this->Form->control('password', ['label' => ['text' => 'Senha']]);
                echo $this->Form->control('categoria_id', ['options' => ['2' => 'Estudante', '3' => 'Professor(a)', '4' => 'Supervisor']]);
                echo $this->Form->control('registro', ['label' => ['text' => 'DRE, Siape ou Cress']]);
                echo $this->Form->control('estudante_id', ['type' => 'hidden', 'options' => $estudantes, 'empty' => true]);
                echo $this->Form->control('supervisor_id', ['type' => 'hidden', 'options' => $supervisores, 'empty' => true]);
                echo $this->Form->control('professor_id', ['type' => 'hidden', 'options' => $docentes, 'empty' => true]);
                echo $this->Form->control('timestamp', ['type' => 'hidden', date('Y-m-d')]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>