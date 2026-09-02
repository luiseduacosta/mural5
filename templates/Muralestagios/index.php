<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
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
            <h1 class="h3 mb-0 text-center text-md-start">Mural de estágios da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        </div>
        <?php if ($user_data['categoria'] === '1'): ?>
            <div>
                <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($user_data['categoria'] === '1'): ?>
        <?= $this->Form->create($muralestagios, ['type' => 'get', 'class' => 'mb-4']); ?>
        <div class="row g-2 align-items-center justify-content-center justify-content-md-start">
            <label class="col-auto col-form-label fw-semibold mb-0">Período</label>
            <div class="col-md-3">
                <?= $this->Form->control('periodo', [
                    'id' => 'MuralestagioPeriodo',
                    'type' => 'select',
                    'label' => false,
                    'options' => $periodos,
                    'empty' => [$periodo => $periodo],
                    'class' => 'form-select',
                    'onchange' => 'this.form.submit();'
                ]); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                            <th><?= $this->Paginator->sort('vagas') ?></th>
                            <th><?= $this->Paginator->sort('beneficios') ?></th>
                            <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                            <th><?= $this->Paginator->sort('carga_horaria', 'CH') ?></th>
                            <th><?= $this->Paginator->sort('data_inscricao', 'Inscrições') ?></th>
                            <th><?= $this->Paginator->sort('data_selecao', 'Seleção') ?></th>
                            <?php if ($user_data['categoria'] === '1'): ?>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($muralestagios as $muralestagio): ?>
                            <tr>
                                <td><?= $muralestagio->id ?></td>
                                <td>
                                    <?php if (isset($user_data) && $user_data['categoria'] != 0) : ?>
                                        <?= isset($muralestagio->instituicao_entidade->instituicao) ? $this->Html->link($muralestagio->instituicao_entidade->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) : '' ?>
                                    <?php else : ?>
                                        <?= isset($muralestagio->instituicao_entidade) ? $muralestagio->instituicao_entidade->instituicao : '' ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= $muralestagio->vagas ?></td>
                                <td><?= h($muralestagio->beneficios) ?></td>
                                <td><?= (h($muralestagio->final_de_semana) == 0) ? 'Não' : 'Sim' ?></td>
                                <td><?= $muralestagio->carga_horaria ?></td>
                                <td><?= isset($muralestagio->data_inscricao) ? $muralestagio->data_inscricao : '' ?></td>
                                <td><?= isset($muralestagio->data_selecao) ? $muralestagio->data_selecao : '' ?></td>
                                <?php if ($user_data['categoria'] === '1'): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralestagio->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza quer quer excluir este registro # {0}?', $muralestagio->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <div class="paginator">
            <ul class="pagination mb-2">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
    </div>
</div>