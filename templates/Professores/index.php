<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
?>
<div class="professores index content">
    <?= $this->Html->link(__('Novo Professor'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Professores') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('siape') ?></th>
                    <th><?= $this->Paginator->sort('datanascimento') ?></th>
                    <th><?= $this->Paginator->sort('localnascimento') ?></th>
                    <th><?= $this->Paginator->sort('sexo') ?></th>
                    <th><?= $this->Paginator->sort('ddd_telefone') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('ddd_celular') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('homepage') ?></th>
                    <th><?= $this->Paginator->sort('redesocial') ?></th>
                    <th><?= $this->Paginator->sort('curriculolattes') ?></th>
                    <th><?= $this->Paginator->sort('atualizacaolattes') ?></th>
                    <th><?= $this->Paginator->sort('curriculosigma') ?></th>
                    <th><?= $this->Paginator->sort('pesquisadordgp') ?></th>
                    <th><?= $this->Paginator->sort('formacaoprofissional') ?></th>
                    <th><?= $this->Paginator->sort('universidadedegraduacao') ?></th>
                    <th><?= $this->Paginator->sort('anoformacao') ?></th>
                    <th><?= $this->Paginator->sort('mestradoarea') ?></th>
                    <th><?= $this->Paginator->sort('mestradouniversidade') ?></th>
                    <th><?= $this->Paginator->sort('mestradoanoconclusao') ?></th>
                    <th><?= $this->Paginator->sort('doutoradoarea') ?></th>
                    <th><?= $this->Paginator->sort('doutoradouniversidade') ?></th>
                    <th><?= $this->Paginator->sort('doutoradoanoconclusao') ?></th>
                    <th><?= $this->Paginator->sort('dataingresso') ?></th>
                    <th><?= $this->Paginator->sort('formaingresso') ?></th>
                    <th><?= $this->Paginator->sort('tipocargo') ?></th>
                    <th><?= $this->Paginator->sort('categoria') ?></th>
                    <th><?= $this->Paginator->sort('regimetrabalho') ?></th>
                    <th><?= $this->Paginator->sort('departamento') ?></th>
                    <th><?= $this->Paginator->sort('dataegresso') ?></th>
                    <th><?= $this->Paginator->sort('motivoegresso') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professores as $professor): ?>
                <tr>
                    <td><?= $this->Number->format($professor->id) ?></td>
                    <td><?= h($professor->nome) ?></td>
                    <td><?= h($professor->cpf) ?></td>
                    <td><?= $this->Number->format($professor->siape) ?></td>
                    <td><?= h($professor->datanascimento) ?></td>
                    <td><?= h($professor->localnascimento) ?></td>
                    <td><?= h($professor->sexo) ?></td>
                    <td><?= h($professor->ddd_telefone) ?></td>
                    <td><?= h($professor->telefone) ?></td>
                    <td><?= h($professor->ddd_celular) ?></td>
                    <td><?= h($professor->celular) ?></td>
                    <td><?= h($professor->email) ?></td>
                    <td><?= h($professor->homepage) ?></td>
                    <td><?= h($professor->redesocial) ?></td>
                    <td><?= h($professor->curriculolattes) ?></td>
                    <td><?= h($professor->atualizacaolattes) ?></td>
                    <td><?= h($professor->curriculosigma) ?></td>
                    <td><?= h($professor->pesquisadordgp) ?></td>
                    <td><?= h($professor->formacaoprofissional) ?></td>
                    <td><?= h($professor->universidadedegraduacao) ?></td>
                    <td><?= $this->Number->format($professor->anoformacao) ?></td>
                    <td><?= h($professor->mestradoarea) ?></td>
                    <td><?= h($professor->mestradouniversidade) ?></td>
                    <td><?= $this->Number->format($professor->mestradoanoconclusao) ?></td>
                    <td><?= h($professor->doutoradoarea) ?></td>
                    <td><?= h($professor->doutoradouniversidade) ?></td>
                    <td><?= $this->Number->format($professor->doutoradoanoconclusao) ?></td>
                    <td><?= h($professor->dataingresso) ?></td>
                    <td><?= h($professor->formaingresso) ?></td>
                    <td><?= h($professor->tipocargo) ?></td>
                    <td><?= h($professor->categoria) ?></td>
                    <td><?= h($professor->regimetrabalho) ?></td>
                    <td><?= h($professor->departamento) ?></td>
                    <td><?= h($professor->dataegresso) ?></td>
                    <td><?= h($professor->motivoegresso) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $professor->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $professor->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $professor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $professor->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
