<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio[]|\Cake\Collection\CollectionInterface $instituicaoestagios
 */
?>
<div class="container">
    <?= $this->Html->link(__('Cadastra nova instituição de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <h3><?= __('Instituições') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('areainstituicoes_id', 'Área institucional') ?></th>
                    <th><?= $this->Paginator->sort('area', 'Área') ?></th>
                    <th><?= $this->Paginator->sort('natureza', 'Natureza') ?></th>
                    <th><?= $this->Paginator->sort('cnpj') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('url', 'URL') ?></th>
                    <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('fax') ?></th>
                    <th><?= $this->Paginator->sort('beneficio', 'Benefício') ?></th>
                    <th><?= $this->Paginator->sort('fim_de_semana') ?></th>
                    <th><?= $this->Paginator->sort('localInscricao', 'Local de inscrição') ?></th>
                    <th><?= $this->Paginator->sort('convenio', 'Convênio') ?></th>
                    <th><?= $this->Paginator->sort('expira') ?></th>
                    <th><?= $this->Paginator->sort('seguro') ?></th>
                    <th><?= $this->Paginator->sort('avaliacao', 'Avaliação') ?></th>
                    <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instituicaoestagios as $instituicaoestagio): ?>
                    <tr>
                        <td><?= $instituicaoestagio->id ?></td>
                        <td><?= $this->Html->link($instituicaoestagio->instituicao, ['controller' => 'instituicaoestagios', 'action' => 'view', $instituicaoestagio->id]) ?>
                        </td>
                        <td><?= $instituicaoestagio->has('areainstituicao') ? $this->Html->link($instituicaoestagio->areainstituicao->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicaoestagio->areainstituicao->id]) : '' ?>
                        </td>
                        <td><?= $instituicaoestagio->has('areaestagio') ? $this->Html->link($instituicaoestagio->areaestagio->area, ['controller' => 'areaestagios', 'action' => 'view', $instituicaoestagio->area]) : '' ?>
                        </td>
                        <td><?= h($instituicaoestagio->natureza) ?></td>
                        <td><?= h($instituicaoestagio->cnpj) ?></td>
                        <td><?= h($instituicaoestagio->email) ?></td>
                        <td><?= h($instituicaoestagio->url) ?></td>
                        <td><?= h($instituicaoestagio->endereco) ?></td>
                        <td><?= h($instituicaoestagio->bairro) ?></td>
                        <td><?= h($instituicaoestagio->municipio) ?></td>
                        <td><?= h($instituicaoestagio->cep) ?></td>
                        <td><?= h($instituicaoestagio->telefone) ?></td>
                        <td><?= h($instituicaoestagio->fax) ?></td>
                        <td><?= h($instituicaoestagio->beneficio) ?></td>
                        <td><?= h($instituicaoestagio->fim_de_semana) ?></td>
                        <td><?= h($instituicaoestagio->localInscricao) ?></td>
                        <td><?= $instituicaoestagio->convenio ?></td>
                        <td><?= $instituicaoestagio->expira ? date('d-m-Y', strtotime(h($instituicaoestagio->expira))) : '' ?>
                        </td>
                        <td><?= h($instituicaoestagio->seguro) ?></td>
                        <td><?= h($instituicaoestagio->avaliacao) ?></td>
                        <td><?= h($instituicaoestagio->observacoes) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $instituicaoestagio->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $instituicaoestagio->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $instituicaoestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicaoestagio->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <?= $this->element('templates') ?>
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