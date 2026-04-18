<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<<<<<<< HEAD
    <?php $usuario = $this->getRequest()->getAttribute('identity'); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $userestagio->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $userestagio->id), 'class' => 'btn btn-danger float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= h($userestagio->email) ?></h3>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $userestagio->id ?></td>
            </tr>
            <tr>
                <th><?= __('Número') ?></th>
                <td><?= $userestagio->registro ?></td>
            </tr>
            <tr>
                <th><?= __('E-mail') ?></th>
                <td><?= h($userestagio->email) ?></td>
            </tr>
            <!--  
             <tr>
                 <th><?= __('Password') ?></th>
                 <td><?= h($userestagio->password) ?></td>
             </tr>
             //-->
            <tr>
                <th><?= __('Categoria') ?></th>
                <td><?= h($userestagio->categoria) ?></td>
            </tr>
            <tr>
                <th><?= __('Aluno') ?></th>
                <td><?= $userestagio->hasValue('aluno') ? $this->Html->link($userestagio->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $userestagio->aluno->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Professor') ?></th>
                <td><?= $userestagio->hasValue('professor') ? $this->Html->link($userestagio->professor->nome, ['controller' => 'Professores', 'action' => 'view', $userestagio->professor->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Supervisor') ?></th>
                <td><?= $userestagio->hasValue('supervisor') ? $this->Html->link($userestagio->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $userestagio->supervisor->id]) : '' ?>
                </td>
            </tr>
            <!--
            <tr>
                <th><?= __('Timestamp') ?></th>
                <td><?= h($userestagio->timestamp) ?></td>
            </tr>
            //-->
        </table>
    </div>
</div>  
=======
<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerUseresView"
            aria-controls="navbarTogglerUsersView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerUserView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo usuário'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar usuário'), ['action' => 'edit', $user->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nva-item">
                <?= $this->Form->postLink(__('Excluir usuaŕio'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que quer excluir # {0}?', $user->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar usuarios'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($user->id) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Categoria') ?></th>
            <td><?= h($user->categoria) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
</div>
>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd
