<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $nome
 */
$categoria_id = 0;

if ($session) {
    $categoria_id = $session->get('categoria_id');
}
?>
<div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAdministrador"
            aria-controls="navbarTogglerAdministrador" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerAdministrador">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $administrador->id],
                        ['confirm' => __('Are you sure you want to delete {0}?', $administrador->nome), 'class' => 'btn btn-danger']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
    <?= $this->Form->create($administrador) ?>
    <fieldset>
        <h3><?= __('Editando Administrador') ?></h3>
        <?php
        if ($categoria_id == 1):
            echo $this->Form->control('user_id', ['type' => 'number', 'class' => 'form-control']);
        endif;
        echo $this->Form->control('nome', ['class' => 'form-control']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Editar', ['class' => 'btn btn-primary'])) ?>
    <?= $this->Form->end() ?>
</div>