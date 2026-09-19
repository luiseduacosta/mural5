<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<?= $this->element('templates') ?>

<?php if ($user_data['categoria'] === '1') { ?>
    <div class="d-flex flex-wrap gap-2 justify-content-end mb-3" aria-label="<?= __('Ações do usuário') ?>">
        <?= $this->Html->link(
            __('Administradores'),
            ['controller' => 'Administradores', 'action' => 'index'],
            ['class' => 'btn btn-primary']
        ) ?>
        <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->postLink(
            __('Excluir'),
            ['action' => 'delete', $user->id],
            [
                'confirm' => __('Tem certeza que quer excluir este registro # {0}?', $user->id),
                'class' => 'btn btn-danger',
            ]
        ) ?>
        <?= $this->Html->link(
            __('Alternar usuário'),
            ['controller' => 'Users', 'action' => 'alternarusuario', '?' => ['id' => $user->id]],
            ['class' => 'btn btn-info']
        ) ?>
    </div>
<?php } ?>

<div class="container">
    <h3><?= h($user->email) ?></h3>
    <table>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $user->id ?></td>
        </tr>
        <tr>
            <th><?= __('Nome') ?></th>
            <?php if ($user->isAdmin()) { ?>
                <td><?= h($user->nome) ?></td>
            <?php } elseif ($user->isAluno()) { ?>
                <td><?= $this->Html->link(
                    $user->nome,
                    ['controller' => 'Alunos', 'action' => 'view', $user->entidade_id]
                    ) ?></td>
            <?php } elseif ($user->isProfessor()) { ?>
                <td><?= $this->Html->link(
                    $user->nome,
                    ['controller' => 'Professores', 'action' => 'view', $user->entidade_id]
                    ) ?></td>
            <?php } elseif ($user->isSupervisor()) { ?>
                <td><?= $this->Html->link(
                    $user->nome,
                    ['controller' => 'Supervisores', 'action' => 'view', $user->entidade_id]
                    ) ?></td>
            <?php } else { ?>
                <td><?= h($user->nome) ?></td>
            <?php } ?>
        </tr>
        <tr>
            <th><?= __('Identificação') ?></th>
            <td><?= h($user->identificacao) ?></td>
        </tr>
        <tr>
            <th><?= __('E-mail') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Categoria') ?></th>
            <td><?= h($user->categoria) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role) ?? '' ?></td>
        </tr>
        <tr>
            <th><?= __('Criado em') ?></th>
            <td><?= $user->criado_em ? $user->criado_em->format('d-m-Y H:i:s') : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Atualizado em') ?></th>
            <td><?= $user->atualizado_em ? $user->atualizado_em->format('d-m-Y H:i:s') : '' ?></td>
        </tr>
    </table>
</div>
