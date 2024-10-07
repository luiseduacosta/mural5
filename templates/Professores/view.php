<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
// pr($professor);
?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                    <?= $this->Html->link(__('Editar Professor'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Form->postLink(__('Excluir Professor'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $professor->id), 'class' => 'btn btn-danger float-end']) ?>
                    <?= $this->Html->link(__('Listar Professores'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Novo Professor'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                <?php elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == 3): ?>
                    <?= $this->Html->link(__('Editar Professor'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-primary float-end']) ?>
                <?php endif; ?>
            </div>
        </aside>
    </div>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor" role="tab" aria-controls="professor"
                    aria-selected="true">Professor(a)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                    aria-selected="false">Estagiários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#notas" role="tab" aria-controls="estagiarios"
                    aria-selected="false">Atividades de estágio</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="professor" class="tab-pane container active show">
            <h3><?= h($professor->nome) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $professor->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Siape') ?></th>
                    <td><?= $professor->siape ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($professor->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($professor->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Local nascimento') ?></th>
                    <td><?= h($professor->localnascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sexo') ?></th>
                    <td><?= h($professor->sexo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ddd Telefone') ?></th>
                    <td><?= h($professor->ddd_telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($professor->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ddd Celular') ?></th>
                    <td><?= h($professor->ddd_celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($professor->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($professor->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Home page') ?></th>
                    <td><?= h($professor->homepage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rede social') ?></th>
                    <td><?= h($professor->redesocial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculo lattes') ?></th>
                    <td><?= h($professor->curriculolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculo sigma') ?></th>
                    <td><?= h($professor->curriculosigma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pesquisador dgp') ?></th>
                    <td><?= h($professor->pesquisadordgp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formacao profissional') ?></th>
                    <td><?= h($professor->formacaoprofissional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Universidade de graduacao') ?></th>
                    <td><?= h($professor->universidadedegraduacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestrado area') ?></th>
                    <td><?= h($professor->mestradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestrado universidade') ?></th>
                    <td><?= h($professor->mestradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutorado area') ?></th>
                    <td><?= h($professor->doutoradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutorado universidade') ?></th>
                    <td><?= h($professor->doutoradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forma de ingresso') ?></th>
                    <td><?= h($professor->formaingresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo de cargo') ?></th>
                    <td><?= h($professor->tipocargo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= h($professor->categoria) ?></td>
                </tr>
                <tr>
                    <th><?= __('Regime de trabalho') ?></th>
                    <td><?= h($professor->regimetrabalho) ?></td>
                </tr>
                <tr>
                    <th><?= __('Departamento') ?></th>
                    <td><?= h($professor->departamento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivo egresso') ?></th>
                    <td><?= h($professor->motivoegresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano formação') ?></th>
                    <td><?= $professor->anoformacao ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestrado ano conclusão') ?></th>
                    <td><?= $professor->mestradoanoconclusao ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutorado ano conclusão') ?></th>
                    <td><?= $professor->doutoradoanoconclusao ?></td>
                </tr>
                <tr>
                    <th><?= __('Data nascimento') ?></th>
                    <td><?= $professor->datanascimento ? date('d-m-Y', strtotime(h($professor->datanascimento))) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Atualização lattes') ?></th>
                    <td><?= $professor->atualizacaolattes ? date('d-m-Y', strtotime(h($professor->atualizacaolattes))) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Data de ingresso') ?></th>
                    <td><?= $professor->dataingresso ? date('d-m-Y', strtotime(h($professor->dataingresso))) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Data de egresso') ?></th>
                    <td><?= $professor->dataegresso ? date('d-m-Y', strtotime(h($professor->dataegresso))) : ' ' ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observações') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($professor->observacoes)); ?>
                </blockquote>
            </div>
        </div>

        <div id="estagiarios" class="tab-pane container fade">
            <h4><?= __('Estagiarios') ?></h4>
            <?php if (!empty($professor->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <th><?= __('Id') ?></th>
                            <?php endif; ?>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajuste 2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Instituição') ?></th>
                            <th><?= __('Supervisora') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                            <th><?= __('Observações') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($professor->estagiarios as $estagiarios): ?>
                            <tr>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= h($estagiarios->id) ?></td>
                                <?php endif; ?>
                                <td><?= $estagiarios->hasValue('estudante') ? $estagiarios->estudante->nome : "" ?></td>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= $estagiarios->hasValue('instituicaoestagio') ? $estagiarios->instituicaoestagio->instituicao : "" ?>
                                </td>
                                <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= h($estagiarios->nota) ?></td>
                                <td><?= h($estagiarios->ch) ?></td>
                                <td><?= h($estagiarios->observacoes) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div id="notas" class="tab-pane container fade">
            <h4><?= __('Atividades') ?></h4>
            <?php if (!empty($professor->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <th><?= __('Id') ?></th>
                            <?php endif; ?>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Atividades') ?></th>
                            <th><?= __('Avaliação estágio') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Instituição') ?></th>
                            <th><?= __('Supervisora') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                            <th><?= __('Observações') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($professor->estagiarios as $estagiarios): ?>
                            <?php // pr($estagiarios->folhadeatividade) ?>
                            <tr>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= h($estagiarios->id) ?></td>
                                <?php endif; ?>
                                <td><?= $estagiarios->hasValue('estudante') ? $estagiarios->estudante->nome : "" ?></td>
                                <td><?= h($estagiarios->registro) ?></td>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 2): ?>
                                    <td><?= $estagiarios->hasValue('folhadeatividade') ? $this->Html->link('Atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'index', $estagiarios->id]) : $this->Html->link('Cadastrar atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiarios->id]]) ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('folhadeatividade') ? $this->Html->link('Atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'index', $estagiarios->id]) : "Sem atividades cadastradas" ?>
                                    </td>
                                <?php endif; ?>
                                <td><?= $estagiarios->hasValue('avaliacao') ? $this->Html->link('Avaliacao de estágio', ['controller' => 'avaliacoes', 'action' => 'view', '?' => ['estagiario_id' => $estagiarios->id]]) : 'Sem avaliações cadastradas' ?>
                                </td>

                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= $estagiarios->hasValue('instituicaoestagio') ? $estagiarios->instituicaoestagio->instituicao : "" ?>
                                </td>
                                <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : "" ?>
                                </td>
                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= h($estagiarios->nota) ?></td>
                                <td><?= h($estagiarios->ch) ?></td>
                                <td><?= h($estagiarios->observacoes) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>