<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$usuario = $this->getRequest()->getAttribute('identity');
// pr($muralinscricao);
?>

<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?php if ($usuario->categoria_id == 1): ?>
                    <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $muralinscricao->id], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                <?php elseif ($usuario->categoria_id == 2): ?>
                    <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger float-end']) ?>
                <?php endif; ?>
            </div>
        </aside>
        <div class="container">
            <h3><?= h($muralinscricao->estudante->nome) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $muralinscricao->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $muralinscricao->registro ?></td>
                </tr>
                <tr>
                    <th><?= __('Estudante') ?></th>
                    <td><?= $muralinscricao->has('estudante') ? $this->Html->link($muralinscricao->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $muralinscricao->estudante->id]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Inscrição para estagio') ?></th>
                    <td><?= $muralinscricao->has('muralestagio') ? $this->Html->link($muralinscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagio->id]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Período') ?></th>
                    <td><?= h($muralinscricao->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= date('d-m-Y', strtotime(h($muralinscricao->data))) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= date('d-m-Y', strtotime(h($muralinscricao->timestamp))) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>