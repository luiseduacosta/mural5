<?php
if (isset($this->getRequest()->getAttribute('identity')['categoria_id'])) {
    $categoria = $this->getRequest()->getAttribute('identity')->get('categoria_id');
} else {
    $categoria = null;
}
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

            <?php if ($categoria): ?>
                <li class="nav-item">
                    <?php echo $this->Html->link("Declaração de período", ['controller' => "Estudantes", 'action' => 'certificadoperiodo', $this->getRequest()->getAttribute('identity')['estudante_id']], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Termo de compromisso", ['controller' => "Estagiarios", 'action' => 'termodecompromisso', '?' => ['estudante_id' => $this->getRequest()->getAttribute('identity')['estudante_id']]], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Declaraçao de estagio", ['controller' => "Estagiarios", 'action' => 'declaracaodeestagiopdf', $this->getRequest()->getSession()->read('estagiario_id')], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                </li>

                <li class="nav-item">
                    <?php echo $this->Html->link("Preenche atividades", ['controller' => 'Folhadeatividades', 'action' => 'view', '?' => ['estagiario_id' => $this->getRequest()->getSession()->read('estagiario_id')]], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Imprime atividades", ['controller' => "Estagiarios", 'action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $this->getRequest()->getSession()->read('estagiario_id')]], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                </li>

                <li class="nav-item">
                    <?php echo $this->Html->link("Avaliaçao", ['controller' => 'Estagiarios', 'action' => 'avaliacaodiscentepdf', '?' => ['estagiario_id' => $this->getRequest()->getSession()->read('estagiario_id')]], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
            <li class="nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>

            <li class="nav-item">
                <?php echo $this->Html->link("Meus dados", ['controller' => "Estudantes", 'action' => 'view?registro=' . $this->getRequest()->getSession()->read('registro')], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
            <li class="nav-item">
                <?php echo $this->Html->link('Sair', ['controller' => 'Userestagios', 'action' => 'logout'], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>

        </ul>

    </div>
</nav>