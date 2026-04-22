<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => '0'];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<?= $this->element('templates') ?>

<div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <?php if ($user_data['administrador_id'] || $user_data['supervisor_id']): ?>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Editar Instituição'), ['action' => 'edit', $instituicao->id], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($user_data['administrador_id'] && $user_data['supervisor_id']): ?>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Nova Instituição'), ['action' => 'add'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Form->postLink(__('Excluir Instituição'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $instituicao->id), 'class' => 'btn btn-danger me-1', 'style' => 'font-size: 10pt;']) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#instituicao" role="tab" aria-controls="instituicao"
                aria-selected="true">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#supervisores" role="tab" aria-controls="supervisores"
                aria-selected="false">Supervisores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#estagiarios" role="tab" aria-controls="estagiarios"
                aria-selected="false">Estagiários</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#muraldeestagio" role="tab" aria-controls="muraldeestagio"
                aria-selected="false">Mural de estágio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#visitas" role="tab" aria-controls="visitas"
                aria-selected="false">Visitas</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="tab-content">
        <div id="instituicao" class="tab-pane container active show">
            <h3><?= $instituicao->instituicao ?></h3>
            <table class="table table-responsive table-hover table-striped">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $instituicao->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <td><?= $instituicao->instituicao ? h($instituicao->instituicao) : 's/d' ?></td>
                </tr>
                <tr>
                    <th><?= __('Área instituicao') ?></th>
                    <td><?= $instituicao->hasvalue('Area') ? $this->Html->link($instituicao->Area->area, ['controller' => 'Areas', 'action' => 'view', $instituicao->Area->id]) : 's/d' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Natureza') ?></th>
                    <td><?= h($instituicao->natureza) ?></td>
                </tr>
                <tr>
                    <th><?= __('CNPJ') ?></th>
                    <td><?= h($instituicao->cnpj) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($instituicao->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço do site') ?></th>
                    <td><?= h($instituicao->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($instituicao->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('CEP') ?></th>
                    <td><?= h($instituicao->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço') ?></th>
                    <td><?= h($instituicao->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($instituicao->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Município') ?></th>
                    <td><?= h($instituicao->municipio) ?></td>
                </tr>

                <tr>
                    <th><?= __('Benefício') ?></th>
                    <td><?= h($instituicao->beneficio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fim de Semana') ?></th>
                    <td><?= ($instituicao->fim_de_semana == 0) ? 'Não' : 'Sim'; ?></td>
                </tr>
                <tr>
                    <th><?= __('Seguro') ?></th>
                    <td><?= ($instituicao->seguro == 0) ? 'Não' : 'Sim'; ?></td>
                </tr>
                <tr>
                    <th><?= __('Convênio') ?></th>
                    <td><?= $instituicao->convenio ?></td>
                </tr>
                <tr>
                    <th><?= __('Expira') ?></th>
                    <td><?= ($instituicao->expira) ?? 'Sem informação' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td><?= h($instituicao->observacoes) ?></td>
                </tr>
            </table>
        </div>

                <div id="supervisores" class="tab-pane container fade">
                    <h3><?= __('Supervisores') ?></h3>
                    <?php if (!empty($instituicao->supervisores)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Nome') ?></th>
                                    <th><?= __('Cress') ?></th>
                                    <th><?= __('Observações') ?></th>
                                    <?php if ($user_data['administrador_id']): ?>
                                        <th class="actions"><?= __('Ações') ?></th>
                                    <?php endif; ?>
                                </tr>
                                <?php foreach ($instituicao->supervisores as $supervisores): ?>
                                    <tr>
                                        <td><?= h($supervisores->id) ?></td>
                                        <?php if ($user_data['administrador_id']): ?>
                                            <td><?= $this->Html->link($supervisores->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?>
                                            </td>
                                        <?php else: ?>
                                            <td><?= $supervisores->nome ?></td>
                                        <?php endif; ?>
                                        <td><?= h($supervisores->cress) ?></td>
                                        <td><?= h($supervisores->observacoes) ?></td>
                                        <?php if ($user_data['administrador_id']): ?>
                                            <td class="actions">
                                                <?= $this->Html->link(__('View'), ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) ?>
                                                <?= $this->Html->link(__('Edit'), ['controller' => 'Supervisores', 'action' => 'edit', $supervisores->id]) ?>
                                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Supervisores', 'action' => 'delete', $supervisores->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $supervisores->id)]) ?>
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
                    <?php if (!empty($instituicao->estagiarios)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Aluno') ?></th>
                                    <th><?= __('Registro') ?></th>
                                    <th><?= __('Supervisor') ?></th>
                                    <th><?= __('Professor') ?></th>
                                    <th><?= __('Período') ?></th>
                                    <th><?= __('Nível') ?></th>
                                    <th><?= __('Ajuste 2020') ?></th>
                                    <th><?= __('Tc') ?></th>
                                    <th><?= __('Tc Solicitação') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th><?= __('Observações') ?></th>
                                    <?php if ($user_data['administrador_id']): ?>
                                        <th class="actions"><?= __('Ações') ?></th>
                                    <?php endif; ?>
                                </tr>
                                <?php foreach ($instituicao->estagiarios as $estagiarios): ?>
                                    <tr>
                                        <td><?= h($estagiarios->id) ?></td>

                                        <?php if ($user_data['administrador_id']): ?>
                                            <td><?= $estagiarios->hasValue('aluno') ? $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?>
                                            </td>
                                        <?php else: ?>
                                            <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                                        <?php endif; ?>

                                <td><?= h($estagiarios->registro) ?></td>

                                        <?php if ($user_data['administrador_id']): ?>
                                            <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                                            </td>
                                        <?php else: ?>
                                            <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : '' ?>
                                            </td>
                                        <?php endif; ?>

                                        <?php if ($user_data['administrador_id']): ?>
                                            <td><?= $estagiarios->hasValue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                            </td>
                                        <?php else: ?>
                                            <td><?= $estagiarios->hasValue('professor') ? $estagiarios->professor->nome : '' ?></td>
                                        <?php endif; ?>

                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                        <?php if ($user_data['administrador_id']): ?>
                                            <td><?= h($estagiarios->ajuste2020) ?></td>
                                            <td><?= h($estagiarios->tc) ?></td>
                                            <td><?= $estagiarios->tc_solicitacao ? date('d-m-Y', strtotime(h($estagiarios->tc_solicitacao))) : '' ?>
                                            </td>
                                            <td><?= !is_null($estagiarios->nota) ? $this->Number->format($estagiarios->nota, ['places' => 2]) : 'Sem dados' ?>
                                            </td>
                                            <td><?= h($estagiarios->ch) ?></td>
                                        <?php else: ?>
                                            <td><?= h($estagiarios->observacoes) ?></td>
                                        <?php endif; ?>
                                            <td class="actions">
                                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiarios->id)]) ?>
                                            </td>
                                        <?php if ($user_data['administrador_id']): ?>
                                            <td><?= h($estagiarios->observacoes) ?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="muraldeestagio" class="tab-pane container fade">
                    <h3><?= __('Ofertas de vagas no Mural de estágios') ?></h3>
                    <?php if (!empty($instituicao->muralestagios)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Instituicoes') ?></th>
                                    <th><?= __('Vagas') ?></th>
                                    <th><?= __('Periodo') ?></th>
                                    <?php if ($user_data['administrador_id']): ?>
                                        <th class="actions"><?= __('Ações') ?></th>
                                    <?php endif; ?>
                                </tr>
                                <?php foreach ($instituicao->muralestagios as $muralestagios): ?>
                                    <tr>
                                        <td><?= h($muralestagios->id) ?></td>
                                        <td><?= $this->Html->link($muralestagios->instituicao, ['controller' => 'muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                        </td>
                                        <td><?= h($muralestagios->vagas) ?></td>
                                        <td><?= h($muralestagios->periodo) ?></td>
                                        <?php if ($user_data['administrador_id']): ?>
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
                    <?php if (!empty($instituicao->visitas)): ?>
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
                                    <?php if ($user_data['administrador_id']): ?>
                                        <th class="actions"><?= __('Ações') ?></th>
                                    <?php endif; ?>
                                </tr>
                                <?php foreach ($instituicao->visitas as $visitas): ?>
                                    <tr>
                                        <td><?= h($visitas->id) ?></td>
                                        <td><?= h($visitas->instituicao_id) ?></td>
                                        <td><?= date('d-m-Y', strtotime($visitas->data)) ?></td>
                                        <td><?= h($visitas->motivo) ?></td>
                                        <td><?= h($visitas->responsavel) ?></td>
                                        <td><?= h($visitas->descricao) ?></td>
                                        <td><?= h($visitas->avaliacao) ?></td>
                                        <?php if ($user_data['administrador_id']): ?>
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