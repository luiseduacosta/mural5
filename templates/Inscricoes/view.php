<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
?>

<?= $this->element('templates') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Navegação">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggler">

        <ul class="navbar-nav ms-auto mt-lg-0">
            <?php if (isset($categoria) && $categoria == 1): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $inscricao->id], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                </li>
            <?php elseif (isset($categoria) && $categoria == 2): ?>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container">
    <h3><?= h($inscricao->aluno->nome) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $inscricao->id ?></td>
        </tr>
        <tr>
            <th><?= __('Registro') ?></th>
            <?php if (isset($categoria) && $categoria == 1): ?>
                <td><?= $inscricao->hasValue('aluno') ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?>
                </td>
            <?php else: ?>
                <td><?= $inscricao->hasValue('aluno') ? $inscricao->aluno->nome : '' ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <th><?= __('Inscrição para estágio') ?></th>
            <?php if (isset($categoria) && $categoria == 1): ?>
                <td><?= $inscricao->hasValue('muralestagio') ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?>
                </td>
            <?php else: ?>
                <td><?= $inscricao->hasValue('muralestagio') ? $inscricao->muralestagio->instituicao : '' ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <th><?= __('Período') ?></th>
            <td><?= h($inscricao->periodo) ?></td>
        </tr>
        <tr>
            <th><?= __('Data') ?></th>
            <td><?= date('d-m-Y', strtotime($inscricao->data)) ?></td>
        </tr>
        <tr>
            <th><?= __('Atualização') ?></th>
            <td><?= date('d-m-Y', strtotime($inscricao->timestamp)) ?></td>
        </tr>
    </table>
</div>