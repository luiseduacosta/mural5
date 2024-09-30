<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$usuario = $this->getRequest()->getAttribute('identity');
// pr($usuario->get('categoria'));
?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?php if ($usuario->categoria == 1): ?>
                    <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $muralinscricao->id], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                <?php elseif ($usuario->get('categoria') == 2): ?>
                    <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger float-end']) ?>
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
                    <td><?= $muralinscricao->id_aluno ?></td>
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