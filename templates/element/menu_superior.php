<?php

declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>
<!-- templates/element/submenu_navegacao.php -->
<script>
    addEventListener('load', () => {
        /* sub menu unselect */
        const navInputs = [...document.querySelectorAll('.toggle-input:not(#nav-toggler)')];
        const unselect = (inputBox) => { inputBox.checked = false };
        const unselectAll = (event) => { navInputs.forEach( (inputBox) => { 
            if (inputBox !== event.target) unselect(inputBox) 
        })};
        addEventListener('mouseup', unselectAll);
        addEventListener('touchend', unselectAll);
    });
</script>
    
<nav class="navbar sticky-top navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ESS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" 
            aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><?php echo $this->Html->link('Mural', ['controller' => 'Muralestagios', 'action' => 'index']); ?></li>
                <?php if ($user_data['categoria'] == 1 || $user_data['categoria'] == 2) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Consulta
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="nav-item">   
                                <?php echo $this->Html->link('Alunos', ['controller' => 'Alunos', 'action' => 'index'], ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">   
                                <?php echo $this->Html->link('Instituicoes', ['controller' => 'Instituicoes', 'action' => 'index'], ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">   
                                <?php echo $this->Html->link('Inscrições', ['controller' => 'Inscricoes', 'action' => 'index'], ['class'=> 'nav-link']); ?>
                            </li>
                            <li class="nav-item">   
                                <?php echo $this->Html->link('Estagiarios', ['controller' => 'Estagiarios', 'action' => 'index'], ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">   
                                <?php echo $this->Html->link('Supervisores', ['controller' => 'Supervisores', 'action' => 'index'], ['class' => 'nav-link']); ?>
                            </li>
                            <li class="nav-item">   
                                <?php echo $this->Html->link('Professores', ['controller' => 'Professores', 'action' => 'index'], ['class' => 'nav-link']); ?>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($user_data['categoria'] == 1) : ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link('Administração', ['controller' => 'Administradores', 'action' => 'index']); ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><?php echo $this->Html->link('Salir', ['controller' => 'Users', 'action' => 'logout']); ?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
