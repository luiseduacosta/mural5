<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>

<?= $this->element('templates') ?>

<div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                    aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <?php if($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo(a) aluno(a'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <h3><?= __('Aluno(a)s') ?></h3>
        <div class="row justify-content-start">
            <div class="col-auto">
                <?php $this->Form->setTemplates(["label" => "<label class='col-3 control-label'>{{text}}</label>"]); ?>
                <?php $this->Form->setTemplates(["input" => "<div class='col-8'><input class='form-control' type='{{type}}' name='{{name}}' {{attrs}}/></div>"]); ?>
                <?= $this->Form->create($alunos, ['url' => ['action' => 'view'], 'type' => 'get']); ?>
                <?= $this->Form->control('registro', ['label' => ['text' => 'Busca por registro']]); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>

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
                    <th><?= $this->Paginator->sort('orgao', 'Orgão') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('codigo_telefone') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_celular') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= $aluno->id ?></td>
                        <td><?= $this->Html->link($aluno->nome, ['controller' => 'alunos', 'action' => 'view', $aluno->id]) ?>
                        </td>
                        <td><?= $aluno->registro ?></td>
                        <td><?= $aluno->nascimento ? date('d-m-Y', strtotime($aluno->nascimento)) : '' ?></td>
                        <td><?= h($aluno->cpf) ?></td>
                        <td><?= h($aluno->identidade) ?></td>
                        <td><?= h($aluno->orgao) ?></td>
                        <td><?= h($aluno->email) ?></td>
                        <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
                        <td><?= h($aluno->telefone) ?></td>
                        <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
                        <td><?= h($aluno->celular) ?></td>
                        <td><?= h($aluno->cep) ?></td>
                        <td><?= h($aluno->endereco) ?></td>
                        <td><?= h($aluno->municipio) ?></td>
                        <td><?= h($aluno->bairro) ?></td>
                        <td><?= h($aluno->observacoes) ?></td>
                        <td>
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id], ['class' => 'link-info']) ?>
                            <?php if($user->isAdmin()): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id], ['class' => 'link-warning']) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id), 'class' => 'link-danger']) ?>
                            <?php endif; ?>
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
</div>