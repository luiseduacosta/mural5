<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if($user->isAdmin()): ?>
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
                <?php endif; ?>
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