<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante[]|\Cake\Collection\CollectionInterface $estudantes
 */
?>
<?= $this->element('templates') ?>
<div class="container">
    <h3><?= __('Estudantes') ?></h3>
    <?php if ($this->getRequest()->getAttribute('identity')->get('categoria_id') == 1): ?>
        <?= $this->Html->link(__('Novo estudante'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        <div class="row justify-content-start">
            <div class="col-auto">
                <?php $this->Form->setTemplates(["label" => "<label class='col-3 control-label'>{{text}}</label>"]); ?>
                <?php $this->Form->setTemplates(["input" => "<div class='col-8'><input class='form-control' type='{{type}}' name='{{name}}' {{attrs}}/></div>"]); ?>
                <?= $this->Form->create($estudantes, ['url' => ['action' => 'view'], 'type' => 'get']); ?>
                <?= $this->Form->control('registro', ['label' => ['text' => 'Busca por registro']]); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('nascimento') ?></th>
                    <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                    <th><?= $this->Paginator->sort('identidade') ?></th>
                    <th><?= $this->Paginator->sort('orgao', 'Orgao') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('codigo_telefone') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_celular') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('endereco', 'Enderco') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('observacoes', 'Observacoes') ?></th>
                    <th class="actions"><?= __('Acoes') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudantes as $estudante): ?>
                    <tr>
                        <td><?= $estudante->id ?></td>
                        <td><?= $this->Html->link($estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $estudante->id]) ?>
                        </td>
                        <td><?= $estudante->registro ?></td>
                        <td><?= $estudante->nascimento ? date('d-m-Y', strtotime($estudante->nascimento)) : '' ?></td>
                        <td><?= h($estudante->cpf) ?></td>
                        <td><?= h($estudante->identidade) ?></td>
                        <td><?= h($estudante->orgao) ?></td>
                        <td><?= h($estudante->email) ?></td>
                        <td><?= $this->Number->format($estudante->codigo_telefone) ?></td>
                        <td><?= h($estudante->telefone) ?></td>
                        <td><?= $this->Number->format($estudante->codigo_celular) ?></td>
                        <td><?= h($estudante->celular) ?></td>
                        <td><?= h($estudante->cep) ?></td>
                        <td><?= h($estudante->endereco) ?></td>
                        <td><?= h($estudante->municipio) ?></td>
                        <td><?= h($estudante->bairro) ?></td>
                        <td><?= h($estudante->observacoes) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $estudante->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estudante->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estudante->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estudante->id)]) ?>
                        </td>
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
    <?= $this->element('paginator_count') ?>