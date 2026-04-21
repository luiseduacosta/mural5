<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => '0'];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">

    <?php if ($user_data['administrador_id']): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'btn btn-primary float-end', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <?= $this->element('templates') ?>

    <div class="row">
        <h3><?= __('Mural de estagios') ?></h3>
    </div>

    <div class="row justify-content-center">
        <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        <?php if ($user_data['administrador_id']): ?>
            <?= $this->Form->create($muralestagios, ['type' => 'get', 'class' => 'form-inline']); ?>
            <div class="form-group row">
                <label class='col-sm-1 col-form-label'>Período</label>
                <div class='col-sm-2'>
                    <?= $this->Form->control('periodo', [
                        'id' => 'MuralestagioPeriodo', 
                    'type' => 'select', 
                    'label' => false, 
                    'options' => $periodos, 
                    'empty' => [$periodo => $periodo], 
                    'class' => 'form-control',
                    'onchange' => 'this.form.submit();'
                    ]); ?>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('vagas') ?></th>
                    <th><?= $this->Paginator->sort('beneficios') ?></th>
                    <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                    <th><?= $this->Paginator->sort('carga_horaria', 'CH') ?></th>
                    <th><?= $this->Paginator->sort('data_inscricao', 'Encerramento das Inscrições') ?></th>
                    <th><?= $this->Paginator->sort('data_selecao', 'Seleção') ?></th>
                    <?php if ($user_data['administrador_id']): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($muralestagios as $muralestagio): ?>
                    <tr>
                        <td><?= $muralestagio->id ?></td>
                        <td><?= $muralestagio->hasValue('instituicao') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) : $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]); ?>
                        </td>
                        <td><?= $muralestagio->vagas ?></td>
                        <td><?= h($muralestagio->beneficios) ?></td>
                        <td><?= (h($muralestagio->final_de_semana) == 0) ? 'Não' : 'Sim' ?></td>
                        <td><?= $muralestagio->carga_horaria ?></td>
                        <td><?= isset($muralestagio->data_inscricao) ? $muralestagio->data_inscricao : '' ?></td>
                        <td><?= isset($muralestagio->data_selecao) ? $muralestagio->data_selecao : '' ?></td>
                        <?php if ($user_data['administrador_id']): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralestagio->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza quer quer excluir este registro # {0}?', $muralestagio->id)]) ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('templates'); ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
    </div>
</div>