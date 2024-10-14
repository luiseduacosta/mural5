<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Usuários</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerUsuario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerUsuario">
            <ul class="navbar-nav me-auto mt-lg-0">
                <li class="nav-item active">
                    <?= $this->Html->link(__('Novo usuário de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
            <form class="d-flex ms-auto">
                <input class="form-control" type="search" placeholder="Pesquisar">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
            </form>
        </div>
    </nav>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('categoria_id') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_id') ?></th>
                    <th><?= $this->Paginator->sort('professor_id') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $userestagio): ?>
                    <tr>
                        <td><?= $userestagio->id ?></td>
                        <td><?= h($userestagio->email) ?></td>
                        <td><?= h($userestagio->categoria_id) ?></td>
                        <td><?= $userestagio->registro ?></td>
                        <td><?= $userestagio->hasValue('aluno') ? $this->Html->link($userestagio->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $userestagio->aluno->id]) : '' ?>
                        </td>
                        <td><?= $userestagio->hasValue('supervisor') ? $this->Html->link($userestagio->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $userestagio->supervisor->id]) : '' ?>
                        </td>
                        <td><?= $userestagio->hasValue('professor') ? $this->Html->link($userestagio->professor->nome, ['controller' => 'Professores', 'action' => 'view', $userestagio->professor->id]) : '' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $userestagio->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $userestagio->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $userestagio->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $this->element('templates'); ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
    </div>
    <?= $this->element('paginator_count') ?>
</div>