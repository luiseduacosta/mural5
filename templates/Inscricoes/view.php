<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao $inscricao
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<?= $this->element('templates') ?>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-0"><?= $inscricao->hasValue('aluno') ? h($inscricao->aluno->nome) : '' ?></h3>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <?php if ($user_data['categoria'] === '1'): ?>
                <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $inscricao->id], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-success']) ?>
                <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger']) ?>
            <?php elseif ($user_data['aluno_id']): ?>
                <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-danger']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <tr><th><?= __('Id') ?></th><td><?= $inscricao->id ?></td></tr>
                <tr><th><?= __('Registro') ?></th><td><?= $inscricao->registro ?></td></tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <?php if ($user_data['categoria'] === '1'): ?>
                        <td><?= $inscricao->has('aluno') ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno->id]) : '' ?></td>
                    <?php else: ?>
                        <td><?= $inscricao->has('aluno') ? $inscricao->aluno->nome : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Inscrição para estágio') ?></th>
                    <td><?= $inscricao->hasValue('muralestagio') ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?></td>
                </tr>
                <tr><th><?= __('Período') ?></th><td><?= h($inscricao->periodo) ?></td></tr>
                <tr><th><?= __('Data') ?></th><td><?= $inscricao->data ? $inscricao->data->format('d/m/Y') : '' ?></td></tr>
                <tr><th><?= __('Atualizado em') ?></th><td><?= $inscricao->timestamp ? $inscricao->timestamp->format('d/m/Y H:i:s') : '' ?></td></tr>
            </table>
        </div>
    </div>
</div>