<?php
$categoria = $user ? $user->categoria_id : null;
?>
<nav class='navbar navbar-expand-lg navbar-light py-0 navbar-fixed-top' style="background-color: #2b6c9c;">
    <?php $logo = $this->Html->image('logoess_horizontal-azul.svg', ['height' => '50', 'width' => '150', 'alt' => 'ESS']); ?>
    <?= $this->Html->link($logo, "http://www.ess.ufrj.br", ['class' => 'navbar-brand', 'style' => 'color: white', 'escape' => false]) ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div style='font-size: 90%' , class='collapse navbar-collapse' id='navbarPrincipal'>
        <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
                <?php echo $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link', 'style' => 'color: white;']); ?>
            </li>
            
            <li class="nav-item">
                <?php echo $this->Html->link("Meus estagiários", ['controller' => "Supervisores", 'action' => 'view', '?' => ['cress' => $this->getRequest()->getSession()->read('cress')]], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
            
            <li class="nav-item">
                <?php echo $this->Html->link('Sair', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>

        </ul>

    </div>
</nav>