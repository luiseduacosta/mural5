<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-0"><?= __('Detalhes da visita') ?></h3>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <?php if ($user_data['categoria'] === '1'): ?>
                <?= $this->Html->link(__('Editar visita'), ['controller' => 'Visitas', 'action' => 'edit', $visita->id], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Nova visita'), ['controller' => 'Visitas', 'action' => 'add'], ['class' => 'btn btn-success']) ?>
                <?= $this->Form->postLink(__('Excluir visita'), ['controller' => 'Visitas', 'action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que deseja excluir este registro de visita {0}?', $visita->id), 'class' => 'btn btn-danger']) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('Listar visitas'), ['controller' => 'Visitas', 'action' => 'index'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <tr><th><?= __('Id') ?></th><td><?= $this->Number->format($visita->id) ?></td></tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <td><?= $visita->has('instituicao') ? $this->Html->link($visita->instituicao['instituicao'], ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao['id']]) : '' ?></td>
                </tr>
                <tr><th><?= __('Motivo') ?></th><td><?= h($visita->motivo) ?></td></tr>
                <tr><th><?= __('Responsável') ?></th><td><?= h($visita->responsavel) ?></td></tr>
                <tr><th><?= __('Avaliação') ?></th><td><?= h($visita->avaliacao) ?></td></tr>
                <tr><th><?= __('Data') ?></th><td><?= h($visita->data) ?></td></tr>
            </table>
            <div class="p-3 border-top">
                <h5><?= __('Descrição') ?></h5>
                <div class="bg-light border rounded p-3">
                    <?= $this->Text->autoParagraph(h($visita->descricao)); ?>
                </div>
            </div>
        </div>
    </div>
</div>