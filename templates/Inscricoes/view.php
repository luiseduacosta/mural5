<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => '0'];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<?= $this->element('templates') ?>

<div class="container">

<nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($user_data['administrador_id']): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $inscricao->id], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size: 10pt;']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:10px']) ?>
                    </li>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size: 10pt;']) ?>
                    </li>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:10px']) ?>
                    </li>
                <?php elseif ($user_data['aluno_id']): ?>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger me-1', 'style' => 'max-width:120px; word-wrap:break-word; font-size:10px']) ?>
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
                <?php if ($user_data['administrador_id']): ?>
                    <td><?= $inscricao->has('aluno') ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?></td>
                <?php else: ?>
                    <td><?= $inscricao->has('aluno') ? $inscricao->aluno->nome : '' ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <th><?= __('Inscrição para estágio') ?></th>
                <td><?= $inscricao->hasValue('muralestagio') ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Período') ?></th>
                <td><?= h($inscricao->periodo) ?></td>
            </tr>
            <tr>
                <th><?= __('Data') ?></th>
                <td><?= $inscricao->data ? $inscricao->data->format('d/m/Y') : '' ?></td>
            </tr>
            <tr>
                <th><?= __('Atualizado em') ?></th>
                <td><?= $inscricao->timestamp ? $inscricao->timestamp->format('d/m/Y H:i:s') : '' ?></td>
            </tr>
        </table>
    </div>
</div>