<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">

    <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo(a) usuário(a)'), ['action' => 'add'], ['class' => 'btn btn-primary float-end', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('categoria') ?></th>
                    <th><?= $this->Paginator->sort('identificacao', 'DRE/Siape/CRESS') ?></th>
                    <th><?= $this->Paginator->sort('entidade_id', 'Entidade ID') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_id') ?></th>
                    <th><?= $this->Paginator->sort('professor_id') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= h($user->nome) ?></td>
                        <td><?= h($user->email) ?></td>
                        <td><?= h($user->categoria) ?></td>
                        <td><?= h($user->identificacao) ?></td>
                        <td><?= h($user->entidade_id) ?></td>
                        <td><?= $user->hasValue('aluno') ? $this->Html->link($user->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $user->aluno->id]) : '' ?>
                        </td>
                        <td><?= $user->hasValue('supervisor') ? $this->Html->link($user->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $user->supervisor->id]) : '' ?>
                        </td>
                        <td><?= $user->hasValue('professor') ? $this->Html->link($user->professor->nome, ['controller' => 'Professores', 'action' => 'view', $user->professor->id]) : '' ?>
                        </td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?>
                            <?php if ($user_data['categoria'] === '1'): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $user->id)]) ?>
                            <?php endif; ?>
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