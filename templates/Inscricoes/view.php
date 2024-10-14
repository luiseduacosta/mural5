<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
$usuario = $this->getRequest()->getAttribute('identity');
// pr($usuario);
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">

            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($usuario->categoria_id == 1): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $inscricao->id], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger float-end']) ?>
                    </li>
                <?php elseif ($usuario->categoria_id == 2): ?>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger float-end']) ?>
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
                <td><?= $inscricao->registro ?></td>
            </tr>
            <tr>
                <th><?= __('Aluno') ?></th>
                <td><?= $inscricao->has('aluno') ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Inscrição para estágio') ?></th>
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