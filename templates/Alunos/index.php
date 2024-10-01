<?php
$categoria = isset($this->getRequest()->getAttribute('identity')['categoria_id']) ? $this->getRequest()->getAttribute('identity')->get('categoria_id') : null; 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>
<?php if ($categoria == '1'): ?>
    <?= $this->Html->link(__('Novo aluno'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
<?php endif; ?>

<h3><?= __('Alunos') ?></h3>
<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('registro') ?></th>
                <th><?= $this->Paginator->sort('nome') ?></th>
                <th><?= $this->Paginator->sort('nascimento') ?></th>
                <th><?= $this->Paginator->sort('cpf') ?></th>
                <th><?= $this->Paginator->sort('identidade') ?></th>
                <th><?= $this->Paginator->sort('orgao') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('codigo_telefone') ?></th>
                <th><?= $this->Paginator->sort('telefone') ?></th>
                <th><?= $this->Paginator->sort('codigo_celular') ?></th>
                <th><?= $this->Paginator->sort('celular') ?></th>
                <th><?= $this->Paginator->sort('cep') ?></th>
                <th><?= $this->Paginator->sort('endereco') ?></th>
                <th><?= $this->Paginator->sort('municipio') ?></th>
                <th><?= $this->Paginator->sort('bairro') ?></th>
                <th><?= $this->Paginator->sort('observacoes') ?></th>
                <?php if ($categoria == '1'): ?>
                    <th class="actions"><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= $aluno->id ?></td>
                    <td><?= $aluno->registro ?></td>
                    <td><?= $this->Html->link($aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?>
                    </td>
                    <td><?= date('d-m-Y', strtotime(h($aluno->nascimento))) ?></td>
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
                    <?php if ($categoria == '1'): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id)]) ?>
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
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>
<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
</p>
</div>