<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicoes
 */
?>
<div class="instituicoes index content">
    <?= $this->Html->link(__('Nova Instituicao'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Instituicoes') ?></h3>
    <div>
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao') ?></th>
                    <th><?= $this->Paginator->sort('areainstituicoes_id') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th><?= $this->Paginator->sort('natureza') ?></th>
                    <th><?= $this->Paginator->sort('cnpj') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('endereco') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('beneficio') ?></th>
                    <th><?= $this->Paginator->sort('fim_de_semana') ?></th>
                    <th><?= $this->Paginator->sort('localInscricao') ?></th>
                    <th><?= $this->Paginator->sort('convenio') ?></th>
                    <th><?= $this->Paginator->sort('expira') ?></th>
                    <th><?= $this->Paginator->sort('seguro') ?></th>
                    <th><?= $this->Paginator->sort('avaliacao') ?></th>
                    <th><?= $this->Paginator->sort('observacoes') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instituicoes as $instituicao): ?>
                <tr>
                    <td><?= $this->Number->format($instituicao->id) ?></td>
                    <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'instituicoes', 'action' => 'view', $instituicao->id]) ?></td>
                    <td><?= $instituicao->areainstituicao ? $this->Html->link($instituicao->areainstituicao->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicao->areainstituicao->id]) : '' ?></td>
                    <td><?= $instituicao->areaestagio ? $this->Html->link($instituicao->areaestagio->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicao->areaestagio->id]) : '' ?></td>
                    <td><?= h($instituicao->natureza) ?></td>
                    <td><?= h($instituicao->cnpj) ?></td>
                    <td><?= $instituicao->email ? $this->Html->link($instituicao->email, 'mailto:' . $instituicao->email) : '' ?></td>
                    <td><?= $instituicao->url ? $this->Html->link($instituicao->url) : '' ?></td>
                    <td><?= h($instituicao->url) ?></td>
                    <td><?= h($instituicao->endereco) ?></td>
                    <td><?= h($instituicao->bairro) ?></td>
                    <td><?= h($instituicao->municipio) ?></td>
                    <td><?= h($instituicao->cep) ?></td>
                    <td><?= h($instituicao->telefone) ?></td>
                    <td><?= h($instituicao->beneficio) ?></td>
                    <td><?= h($instituicao->fim_de_semana) ?></td>
                    <td><?= h($instituicao->localInscricao) ?></td>
                    <td><?= $this->Number->format($instituicao->convenio) ?></td>
                    <td><?= h($instituicao->expira) ?></td>
                    <td><?= h($instituicao->seguro) ?></td>
                    <td><?= h($instituicao->avaliacao) ?></td>
                    <td><?= h($instituicao->observacoes) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $instituicao->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $instituicao->id]) ?>
                        <?= $this->Form->postLink(__('Deletar'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicao->id)]) ?>
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