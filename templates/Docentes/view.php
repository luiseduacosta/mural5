<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
// pr($docente);
?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                    <?= $this->Html->link(__('Editar Docente'), ['action' => 'edit', $docente->id], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Form->postLink(__('Excluir Docente'), ['action' => 'delete', $docente->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $docente->id), 'class' => 'btn btn-danger float-end']) ?>
                    <?= $this->Html->link(__('Listar Docentes'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Novo Docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                <?php elseif ($this->getRequest()->getAttribute('identity')['categoria'] == 3): ?>
                    <?= $this->Html->link(__('Editar Docente'), ['action' => 'edit', $docente->id], ['class' => 'btn btn-primary float-end']) ?>
                <?php endif; ?>
            </div>
        </aside>
    </div>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#docente" role="tab" aria-controls="docente" aria-selected="true">Professor(a)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios" aria-selected="false">Estagiários</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="docente" class="tab-pane container active show">
            <h3><?= h($docente->id) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $docente->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Siape') ?></th>
                    <td><?= $docente->siape ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($docente->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($docente->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Local nascimento') ?></th>
                    <td><?= h($docente->localnascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sexo') ?></th>
                    <td><?= h($docente->sexo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ddd Telefone') ?></th>
                    <td><?= h($docente->ddd_telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($docente->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ddd Celular') ?></th>
                    <td><?= h($docente->ddd_celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($docente->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($docente->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Home page') ?></th>
                    <td><?= h($docente->homepage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rede social') ?></th>
                    <td><?= h($docente->redesocial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculo lattes') ?></th>
                    <td><?= h($docente->curriculolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculo sigma') ?></th>
                    <td><?= h($docente->curriculosigma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pesquisador dgp') ?></th>
                    <td><?= h($docente->pesquisadordgp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formacao profissional') ?></th>
                    <td><?= h($docente->formacaoprofissional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Universidade de graduacao') ?></th>
                    <td><?= h($docente->universidadedegraduacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestrado area') ?></th>
                    <td><?= h($docente->mestradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestrado universidade') ?></th>
                    <td><?= h($docente->mestradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutorado area') ?></th>
                    <td><?= h($docente->doutoradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutorado universidade') ?></th>
                    <td><?= h($docente->doutoradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forma de ingresso') ?></th>
                    <td><?= h($docente->formaingresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo de cargo') ?></th>
                    <td><?= h($docente->tipocargo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= h($docente->categoria) ?></td>
                </tr>
                <tr>
                    <th><?= __('Regime de trabalho') ?></th>
                    <td><?= h($docente->regimetrabalho) ?></td>
                </tr>
                <tr>
                    <th><?= __('Departamento') ?></th>
                    <td><?= h($docente->departamento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivo egresso') ?></th>
                    <td><?= h($docente->motivoegresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano formação') ?></th>
                    <td><?= $docente->anoformacao ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestrado ano conclusão') ?></th>
                    <td><?= $docente->mestradoanoconclusao ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutorado ano conclusão') ?></th>
                    <td><?= $docente->doutoradoanoconclusao ?></td>
                </tr>
                <tr>
                    <th><?= __('Data nascimento') ?></th>
                    <td><?= $docente->datanascimento ? date('d-m-Y', strtotime(h($docente->datanascimento))) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Atualização lattes') ?></th>
                    <td><?= $docente->atualizacaolattes ? date('d-m-Y', strtotime(h($docente->atualizacaolattes))) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Data de ingresso') ?></th>
                    <td><?= $docente->dataingresso ? date('d-m-Y', strtotime(h($docente->dataingresso))) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Data de egresso') ?></th>
                    <td><?= $docente->dataegresso ? date('d-m-Y', strtotime(h($docente->dataegresso))) : ' ' ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observações') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($docente->observacoes)); ?>
                </blockquote>
            </div>
        </div>

        <div id="estagiarios" class="tab-pane container fade">
            <h4><?= __('Estagiarios') ?></h4>
            <?php if (!empty($docente->estagiarios)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
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
                        <?php foreach ($docente->estagiarios as $estagiarios) : ?>
                            <tr>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                                    <td><?= h($estagiarios->id) ?></td>
                                <?php endif; ?>
                                <td><?= h($estagiarios->estudante->nome) ?></td>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->instituicaoestagio->instituicao) ?></td>
                                <td><?= isset($estagiarios->supervisor->nome) ? $estagiarios->supervisor->nome : '' ?></td>
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