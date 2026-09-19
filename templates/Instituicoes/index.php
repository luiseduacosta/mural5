<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicao
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 page-header">
        <div>
            <h1 class="mb-1"><?= __('Instituições') ?></h1>
            <p class="text-muted mb-0">Consulta e gestão das instituições vinculadas ao programa.</p>
        </div>

        <?php if ($user_data['categoria'] === '1'): ?>
            <div>
                <?= $this->Html->link(__('Nova instituição'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('area_id', 'Área') ?></th>
                    <th><?= $this->Paginator->sort('cnpj', 'CNPJ') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('beneficios', 'Benefício') ?></th>
                    <th><?= $this->Paginator->sort('fim_de_semana') ?></th>
                    <th><?= $this->Paginator->sort('convenio', 'Convênio') ?></th>
                    <th><?= $this->Paginator->sort('expira') ?></th>
                    <th><?= $this->Paginator->sort('seguro') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instituicoes as $instituicao): ?>
                    <tr>
                        <td><?= $instituicao->id ?></td>
                        <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?>
                        </td>
                        <td><?= $instituicao->hasValue('Area') ? $this->Html->link($instituicao->Area->area, ['controller' => 'Areas', 'action' => 'view', $instituicao->Area->id]) : '' ?></td>
                           </td>
                        <td><?= h($instituicao->cnpj) ?></td>
                        <td><?= h($instituicao->telefone) ?></td>
                        <td><?= h($instituicao->beneficios) ?></td>
                        <td><?= h($instituicao->fim_de_semana ? 'Sim' : 'Não') ?></td>
                        <td><?= $instituicao->convenio ?></td>
                        <td><?= $instituicao->expira ? date('d-m-Y', strtotime(h($instituicao->expira))) : '' ?>
                        </td>
                        <td><?= $instituicao->seguro ? 'Sim' : 'Não' ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $instituicao->id]) ?>
                            <?php if ($user_data['categoria'] === '1'): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $instituicao->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $instituicao->id)]) ?>
                            <?php endif; ?>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <?= $this->element('paginator') ?>
    </div>
    <?= $this->element('paginator_count') ?>
</div>