<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 */
// pr($instituicaoestagio);
// pr($this->getRequest()->getAttribute('identity'));
// die();
?>
<div class="container">
    <div class="row">
        <div class="container">
            <?php if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                <?= $this->Html->link(__('Editar Instituição de estágio'), ['action' => 'edit', $instituicaoestagio->id], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Html->link(__('Listar instituições de estágio'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Html->link(__('Nova Instituição de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Form->postLink(__('Excluir Instituição de estágio'), ['action' => 'delete', $instituicaoestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $instituicaoestagio->id), 'class' => 'btn btn-danger float-end']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#instituicao" role="tab"
                    aria-controls="instituicao" aria-selected="true">Instituição</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#supervisores" role="tab" aria-controls="supervisores"
                    aria-selected="false">Supervisores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                    aria-selected="false">Estagiários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#muraldeestagio" role="tab"
                    aria-controls="muraldeestagio" aria-selected="false">Mural de estágio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#visitas" role="tab" aria-controls="visitas"
                    aria-selected="false">Visitas</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="tab-content">

            <div id="instituicao" class="tab-pane container active show">
                <h3><?= $instituicaoestagio->instituicao ?></h3>
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $instituicaoestagio->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Instituição') ?></th>
                        <td><?= $instituicaoestagio->instituicao ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Área instituicao') ?></th>
                        <?php if (!empty($instituicaoestagio->areainstituicao->area)): ?>
                            <td><?= $instituicaoestagio->has('areainstituicao') ? $this->Html->link($instituicaoestagio->areainstituicao->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicaoestagio->areainstituicao->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Natureza') ?></th>
                        <td><?= h($instituicaoestagio->natureza) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Cnpj') ?></th>
                        <td><?= h($instituicaoestagio->cnpj) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('E-mail') ?></th>
                        <td><?= h($instituicaoestagio->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Url') ?></th>
                        <td><?= h($instituicaoestagio->url) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Telefone') ?></th>
                        <td><?= h($instituicaoestagio->telefone) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Fax') ?></th>
                        <td><?= h($instituicaoestagio->fax) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Cep') ?></th>
                        <td><?= h($instituicaoestagio->cep) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Endereço') ?></th>
                        <td><?= h($instituicaoestagio->endereco) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Bairro') ?></th>
                        <td><?= h($instituicaoestagio->bairro) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Município') ?></th>
                        <td><?= h($instituicaoestagio->municipio) ?></td>
                    </tr>

                    <tr>
                        <th><?= __('Beneficios') ?></th>
                        <td><?= h($instituicaoestagio->beneficio) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Fim de Semana') ?></th>
                        <td><?= ($instituicaoestagio->fim_de_semana == 0) ? 'Não' : 'Sim'; ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Local de inscrição') ?></th>
                        <td><?= h($instituicaoestagio->localInscricao) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Seguro') ?></th>
                        <td><?= ($instituicaoestagio->seguro == 0) ? 'Não' : 'Sim'; ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Avaliação') ?></th>
                        <td><?= h($instituicaoestagio->avaliacao) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Área') ?></th>
                        <td><?= $instituicaoestagio->area ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Convênio') ?></th>
                        <td><?= ($instituicaoestagio->convenio == 0) ? 'Não' : 'Sim' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Expira') ?></th>
                        <td><?= ($instituicaoestagio->expira) ? date('d-m-Y', strtotime($instituicaoestagio->expira)) : 'Sem informação' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Observações') ?></th>
                        <td><?= h($instituicaoestagio->observacoes) ?></td>
                    </tr>
                </table>
            </div>

            <div id="supervisores" class="tab-pane container fade">
                <h3><?= __('Supervisores') ?></h3>
                <?php if (!empty($instituicaoestagio->supervisores)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Nome') ?></th>
                                <th><?= __('Cress') ?></th>
                                <th><?= __('Observações') ?></th>
                                <?php if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <th class="actions"><?= __('Ações') ?></th>
                                <?php endif; ?>
                            </tr>
                            <?php foreach ($instituicaoestagio->supervisores as $supervisores): ?>
                                <tr>
                                    <td><?= h($supervisores->id) ?></td>
                                    <?php if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td><?= $this->Html->link($supervisores->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?>
                                        </td>
                                    <?php else: ?>
                                        <td><?= $supervisores->nome ?></td>
                                    <?php endif; ?>
                                    <td><?= h($supervisores->cress) ?></td>
                                    <td><?= h($supervisores->observacoes) ?></td>
                                    <?php if (isset($this->getRequest()->getAttribute('identity')['categoria']) && $this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?>
                                            <?= $this->Html->link(__('Edit'), ['controller' => 'Supervisores', 'action' => 'edit', $supervisores->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Supervisores', 'action' => 'delete', $supervisores->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisores->id)]) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div id="estagiarios" class="tab-pane container fade">
                <h3><?= __('Estagiarios') ?></h3>
                <?php if (!empty($instituicaoestagio->estagiarios)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Estudante') ?></th>
                                <th><?= __('Registro') ?></th>
                                <th><?= __('Supervisor') ?></th>
                                <th><?= __('Docente') ?></th>
                                <th><?= __('Período') ?></th>
                                <th><?= __('Nível') ?></th>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <th><?= __('Ajuste 2020') ?></th>
                                    <th><?= __('Turno') ?></th>
                                    <th><?= __('Tc') ?></th>
                                    <th><?= __('Tc Solicitação') ?></th>
                                    <th><?= __('Instituição de estagio') ?></th>
                                    <th><?= __('Área de estágio') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th><?= __('Observações') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                <?php endif; ?>
                            </tr>
                            <?php foreach ($instituicaoestagio->estagiarios as $estagiarios): ?>
                                <?php // pr($estagiarios->areaestagio); ?>
                                <tr>
                                    <td><?= h($estagiarios->id) ?></td>

                                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td><?= $estagiarios->has('estudante') ? $this->Html->link($estagiarios->estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $estagiarios->alunonovo_id]) : '' ?>
                                        </td>
                                    <?php else: ?>
                                        <td><?= $estagiarios->has('estudante') ? $estagiarios->estudante->nome : '' ?></td>
                                    <?php endif; ?>

                                    <td><?= h($estagiarios->registro) ?></td>

                                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td><?= $estagiarios->has('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->id_supervisor]) : '' ?>
                                        </td>
                                    <?php else: ?>
                                        <td><?= $estagiarios->has('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                    <?php endif; ?>

                                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td><?= $estagiarios->has('docente') ? $this->Html->link($estagiarios->docente->nome, ['controller' => 'docentes', 'action' => 'view', $estagiarios->id_professor]) : '' ?>
                                        </td>
                                    <?php else: ?>
                                        <td><?= $estagiarios->has('docente') ? $estagiarios->docente->nome : '' ?></td>
                                    <?php endif; ?>

                                    <td><?= h($estagiarios->periodo) ?></td>
                                    <td><?= h($estagiarios->nivel) ?></td>

                                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td><?= h($estagiarios->ajuste2020) ?></td>
                                        <td><?= h($estagiarios->turno) ?></td>
                                        <td><?= h($estagiarios->tc) ?></td>
                                        <td><?= $estagiarios->tc_solicitacao ? date('d-m-Y', strtotime(h($estagiarios->tc_solicitacao))) : '' ?>
                                        </td>
                                        <td><?= $estagiarios->has('areaestagio') ? $estagiarios->areaestagio->area : '' ?></td>
                                        <td><?= $this->Number->format($estagiarios->nota, ['places' => 2]) ?></td>
                                        <td><?= h($estagiarios->ch) ?></td>
                                        <td><?= h($estagiarios->observacoes) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiarios->id)]) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div id="muraldeestagio" class="tab-pane container fade">
                <h3><?= __('Ofertas de vagas no Mural de estágios') ?></h3>
                <?php if (!empty($instituicaoestagio->muralestagios)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Instituicao') ?></th>
                                <th><?= __('Vagas') ?></th>
                                <th><?= __('Periodo') ?></th>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <th class="actions"><?= __('Ações') ?></th>
                                <?php endif; ?>
                            </tr>
                            <?php foreach ($instituicaoestagio->muralestagios as $muralestagios): ?>
                                <tr>
                                    <td><?= h($muralestagios->id) ?></td>
                                    <td><?= $this->Html->link($muralestagios->instituicao, ['controller' => 'muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                    </td>
                                    <td><?= h($muralestagios->vagas) ?></td>
                                    <td><?= h($muralestagios->periodo) ?></td>
                                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td class="actions">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id]) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralestagios->id)]) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div id="visitas" class="tab-pane container fade">
                <h3><?= __('Visitas realizadas') ?></h3>
                <?php if (!empty($instituicaoestagio->visitas)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Instituição') ?></th>
                                <th><?= __('Data') ?></th>
                                <th><?= __('Motivo') ?></th>
                                <th><?= __('Responsável') ?></th>
                                <th><?= __('Descrição') ?></th>
                                <th><?= __('Avaliação') ?></th>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <th class="actions"><?= __('Ações') ?></th>
                                <?php endif; ?>
                            </tr>
                            <?php foreach ($instituicaoestagio->visitas as $visitas): ?>
                                <tr>
                                    <td><?= h($visitas->id) ?></td>
                                    <td><?= h($visitas->estagio_id) ?></td>
                                    <td><?= date('d-m-Y', strtotime($visitas->data)) ?></td>
                                    <td><?= h($visitas->motivo) ?></td>
                                    <td><?= h($visitas->responsavel) ?></td>
                                    <td><?= h($visitas->descricao) ?></td>
                                    <td><?= h($visitas->avaliacao) ?></td>
                                    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                        <td class="actions">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Visitas', 'action' => 'view', $visitas->id]) ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Visitas', 'action' => 'edit', $visitas->id]) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Visitas', 'action' => 'delete', $visitas->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $visitas->id)]) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>