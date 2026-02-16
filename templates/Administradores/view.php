<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $administrador
 */
?>

<?php $user = $this->getRequest()->getAttribute('identity'); ?>

<div class="row">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAdministrador"
            aria-controls="navbarTogglerAdministrador" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerAdministrador">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <?php if ($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo Administrador'), ['action' => 'add'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Administrador'), ['action' => 'edit', $administrador->id], ['class' => 'btn btn-primary']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir Administrador'), ['action' => 'delete', $administrador->id], ['confirm' => __('Are you sure you want to delete {0}?', $administrador->nome), 'class' => 'btn btn-danger']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <h3>admin_<?= h($administrador->id) ?></h3>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($administrador->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($administrador->nome) ?></td>
        </tr>
    </table>

    <?php if (!empty($administrador->user)): ?>
        <div class="row">
            <h4><?= __('Related User') ?></h4>
            <div class="table_wrap">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th><?= __('Ações') ?></th>
                        <th><?= __('Id') ?></th>
                        <th><?= __('Email') ?></th>
                        <th><?= __('Registro') ?></th>
                        <th><?= __('Data') ?></th>
                    </tr>
                    <tr>
                        <td>
                            <?= $this->Html->link(__('Ver'), ['controller' => 'Users', 'action' => 'view', $administrador->user->id], ['class' => 'link-info']) ?>
                            <?php if ($user->isAdmin()): ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $administrador->user->id], ['class' => 'link-warning']) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Users', 'action' => 'delete', $administrador->user->id], ['confirm' => __('Are you sure you want to delete user_{0}?', $administrador->user->id), 'class' => 'link-danger']) ?>
                            <?php endif; ?>
                        </td>

                        <td><?= $this->Html->link($administrador->user->id, ['controller' => 'Users', 'action' => 'view', $administrador->user->id]) ?>
                        </td>
                        <td><?= $administrador->user->email ? $this->Text->autoLinkEmails($administrador->user->email) : '' ?>
                        </td>
                        <td><?= h($administrador->user->registro) ?></td>
                        <td><?= h($administrador->user->timestamp) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>