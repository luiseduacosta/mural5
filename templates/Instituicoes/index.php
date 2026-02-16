<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicoes
 */
?>

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
                            <?= $this->Html->link(__('Nova instituição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

    <h3><?= __('Instituições') ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('area', 'Área institucional') ?></th>
                    <th><?= $this->Paginator->sort('natureza', 'Natureza') ?></th>
                    <th><?= $this->Paginator->sort('cnpj', 'CNPJ') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('url', 'URL') ?></th>
                    <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                    <th><?= $this->Paginator->sort('bairro') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('cep', 'CEP') ?></th>
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
                <?php foreach ($instituicoes as $instituicao): ?>
                    <?php // pr($instituicao) ?>
                    <tr>
                        <td><?= $instituicao->id ?></td>
                        <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'instituicoes', 'action' => 'view', $instituicao->id]) ?>
                        </td>
                        <td><?= $instituicao->hasValue('area') ? $this->Html->link($instituicao->area->area, ['controller' => 'Areas', 'action' => 'view', $instituicao->area->id]) : '' ?>
                        </td>
                        <td><?= h($instituicao->natureza) ?></td>
                        <td><?= h($instituicao->cnpj) ?></td>
                        <td><?= h($instituicao->email) ?></td>
                        <td><?= h($instituicao->url) ?></td>
                        <td><?= h($instituicao->endereco) ?></td>
                        <td><?= h($instituicao->bairro) ?></td>
                        <td><?= h($instituicao->municipio) ?></td>
                        <td><?= h($instituicao->cep) ?></td>
                        <td><?= h($instituicao->telefone) ?></td>
                        <td><?= h($instituicao->fax) ?></td>
                        <td><?= h($instituicao->beneficio) ?></td>
                        <td><?= h($instituicao->fim_de_semana) ?></td>
                        <td><?= h($instituicao->localInscricao) ?></td>
                        <td><?= $instituicao->convenio ?></td>
                        <td><?= $instituicao->expira ? date('d-m-Y', strtotime($instituicao->expira)) : '' ?>
                        </td>
                        <td><?= h($instituicao->seguro) ?></td>
                        <td><?= h($instituicao->avaliacao) ?></td>
                        <td><?= h($instituicao->observacoes) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $instituicao->id]) ?>
                            <?php if($user->isAdmin()): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $instituicao->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $instituicao->id)]) ?>
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