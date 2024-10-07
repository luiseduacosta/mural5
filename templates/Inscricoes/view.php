<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
$usuario = $this->getRequest()->getAttribute('identity');
// pr($inscricao);
?>

<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?php if ($usuario->categoria_id == 1): ?>
                    <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $inscricao->id], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                <?php elseif ($usuario->categoria_id == 2): ?>
                    <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger float-end']) ?>
                <?php endif; ?>
            </div>
        </aside>
        <div class="container">
            <h3><?= h($inscricao->estudante->nome) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $inscricao->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $inscricao->registro ?></td>
                </tr>
                <tr>
                    <th><?= __('Estudante') ?></th>
                    <td><?= $inscricao->has('estudante') ? $this->Html->link($inscricao->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $inscricao->estudante->id]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Inscrição para estagio') ?></th>
                    <td><?= $inscricao->has('muralestagio') ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Período') ?></th>
                    <td><?= h($inscricao->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= date('d-m-Y', strtotime(h($inscricao->data))) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= date('d-m-Y', strtotime(h($inscricao->timestamp))) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>