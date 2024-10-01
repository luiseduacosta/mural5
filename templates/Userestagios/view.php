<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userestagio $userestagio
 */
?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Ações') ?></h4>
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $userestagio->id], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $userestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userestagio->id), 'class' => 'btn btn-danger float-end']) ?>
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="userestagios view content">
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
                        <th><?= __('Docente') ?></th>
                        <td><?= $userestagio->hasValue('docente') ? $this->Html->link($userestagio->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $userestagio->docente->id]) : '' ?>
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
    </div>
</div>