<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $nome
 */
?>

<div class="row">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAdministrador"
            aria-controls="navbarTogglerAdministrador" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerAdministrador">
                <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </nav>

    <?= $this->Form->create($administrador) ?>
    <fieldset>
        <h3><?= __('Adicionando Administrador') ?></h3>
        <?php
        if ($categoria_id == 1):
            $val = $this->request->getParam('pass') ? $this->request->getParam('pass')[0] : '';
            echo $this->Form->control('user_id', ['type' => 'number', 'value' => $val]);
        endif;
        echo $this->Form->control('nome', ['class' => 'form-control']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Adicionar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

</div>