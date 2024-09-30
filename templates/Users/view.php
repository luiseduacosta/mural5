<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="users view content">
            <aside>
                <div class="side-nav">
                    <?= $this->Html->link(__('Editar User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
                    <?= $this->Form->postLink(__('Deletar User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Listar Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                    <?= $this->Html->link(__('Novo User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= h($user->categoria) ?></td>
                </tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $user->has('aluno') ? $this->Html->link($user->aluno->id, ['controller' => 'Alunos', 'action' => 'view', $user->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Supervisor') ?></th>
                    <td><?= $user->has('supervisor') ? $this->Html->link($user->supervisor->id, ['controller' => 'Supervisores', 'action' => 'view', $user->supervisor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <td><?= $user->has('professor') ? $this->Html->link($user->professor->id, ['controller' => 'Professor', 'action' => 'view', $user->professor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Numero') ?></th>
                    <td><?= $this->Number->format($user->numero) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($user->timestamp) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
