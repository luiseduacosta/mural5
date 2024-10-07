<?php
if (isset($this->getRequest()->getAttribute('identity')['categoria_id'])) {
    $categoria = $this->getRequest()->getAttribute('identity')['categoria_id'];
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
            <?php
            if ($categoria == 1) {
                ?>

                <li class="nav-item dropdown">
                    <a style='color:white' class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">Declarações</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php echo $this->Html->link("Declaração de período", "/Estudantes/index", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                        <?php echo $this->Html->link("Termo de compromisso", "/Estudantes/index", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                        <?php echo $this->Html->link("Declaração de estágio", "/Estudante/index", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Folha de atividades", "/Estudantes/index", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Folha de atividades on-line", "/Estudantes/index", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Folha de avaliação discente", "/Estudantes/index", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Formulário de avaliação discente on-line", "/Estudantes/index/", ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </div>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Estudantes", "/Estudantes/index", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Instituições", "/Instituicaoestagios/index", ['escape' => FALSE, 'class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Supervisores", "/Supervisores/index/ordem:nome", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Professores", "/Professores/index/", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item dropdown">
                    <a style='color: white' class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link('Configuração', '/Configuracoes/view/1', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Usuários', '/Userestagios/index', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Planilha seguro', '/Estudantes/planilhaseguro/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Planilha CRESS', '/Estudantes/planilhacress/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Carga horária', '/Estudantes/cargahoraria/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Complemento período', '/Complementos/index/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Turmas de estágio', '/Turmaestagios/index/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </div>
                </li>
            <?php }
            ; ?>

            <li class="nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
            <li class="nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>

            <?php if ($categoria) { ?>
                <li class="nav-item">
                    <?php echo $this->Html->link("Logout", ['controller' => 'Userestagios', 'action' => 'logout'], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <?php echo $this->Html->link("Login", ['controller' => 'Userestagios', 'action' => 'logout'], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
            <?php } ?>

        </ul>

    </div>
</nav>