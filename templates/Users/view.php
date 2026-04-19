<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->element('templates') ?>

<?php if (isset($categoria) && $categoria == 1): ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $userestagio->id), 'class' => 'btn btn-danger float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>
<?php endif; ?>

    <div class="container">
        <h3><?= h($user->email) ?></h3>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $user->id ?></td>
            </tr>
            <tr>
                <th><?= __('Número') ?></th>
                <td><?= $user->registro ?></td>
            </tr>
            <tr>
                <th><?= __('E-mail') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <!--  
             <tr>
                 <th><?= __('Password') ?></th>
                 <td><?= h($user->password) ?></td>
             </tr>
             //-->
            <tr>
                <th><?= __('Categoria') ?></th>
                <td><?= h($user->categoria) ?></td>
            </tr>
            <tr>
                <th><?= __('Aluno') ?></th>
                <td><?= $user->hasValue('alunos') ? $this->Html->link($user->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $user->aluno->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Professor') ?></th>
                <td><?= $user->hasValue('professores') ? $this->Html->link($user->professor->nome, ['controller' => 'Professores', 'action' => 'view', $user->professor->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Supervisor') ?></th>
                <td><?= $user->hasValue('supervisores') ? $this->Html->link($user->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $user->supervisor->id]) : '' ?>
                </td>
            </tr>
            <!--
            <tr>
                <th><?= __('Timestamp') ?></th>
                <td><?= h($user->timestamp) ?></td>
            </tr>
            //-->
        </table>
    </div>
</div>  
