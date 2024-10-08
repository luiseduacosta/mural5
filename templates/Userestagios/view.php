<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
 */
?>
<div class="container">
        <nav class="navbar navbar-expand-lg py-0 navbar-light bg-light">
        <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $userestagio->id], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $userestagio->id), 'class' => 'btn btn-danger float-end']) ?>
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
                <th><?= __('Estudante') ?></th>
                <td><?= $userestagio->hasValue('estudante') ? $this->Html->link($userestagio->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $userestagio->estudante->id]) : '' ?>
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