<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areaestagio $areaestagio
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Editar área de estágio'), ['action' => 'edit', $areaestagio->id], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Form->postLink(__('Excluir área de estágio'), ['action' => 'delete', $areaestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $areaestagio->id), 'class' => 'btn btn-danger float-end']) ?>
            <?= $this->Html->link(__('Listar área de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link(__('Nova área de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areaestagios view content">
            <h3><?= h($areaestagio->area) ?></h3>
            <table class="table table-stripted table-hover table-responsive">
                <tr>
                    <th><?= __('Área de estágio') ?></th>
                    <td><?= h($areaestagio->area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $areaestagio->id ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Estagiários') ?></h4>
                <?php if (!empty($areaestagio->estagiarios)): ?>
                    <div class="table-responsive">
                        <table class="table table-stripted table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Aluno Id') ?></th>
                                <th><?= __('Estudante Id') ?></th>
                                <th><?= __('Registro') ?></th>
                                <th><?= __('Ajuste curricular 2020') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Nivel') ?></th>
                                <th><?= __('Tc') ?></th>
                                <th><?= __('Tc Solicitacao') ?></th>
                                <th><?= __('Instituicaoestagio Id') ?></th>
                                <th><?= __('Supervisor Id') ?></th>
                                <th><?= __('Docente Id') ?></th>
                                <th><?= __('Periodo') ?></th>
                                <th><?= __('Areaestagio Id') ?></th>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('Ch') ?></th>
                                <th><?= __('Observacoes') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                            <?php foreach ($areaestagio->estagiarios as $estagiarios): ?>
                                <tr>
                                    <?php // pr($estagiarios); ?>
                                    <?php // die(); ?>
                                    <td><?= h($estagiarios->id) ?></td>
                                    <td><?= $estagiarios->has('aluno') ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->id_aluno]) : '' ?>
                                    </td>
                                    <td><?= $estagiarios->has('estudante') ? $this->Html->link(h($estagiarios->estudante->nome), ['controller' => 'estudantes', 'action' => 'view', $estagiarios->alunonovo_id]) : '' ?>
                                    </td>
                                    <td><?= h($estagiarios->registro) ?></td>
                                    <td><?= h($estagiarios->ajuste2020) ?></td>
                                    <td><?= h($estagiarios->turno) ?></td>
                                    <td><?= h($estagiarios->nivel) ?></td>
                                    <td><?= h($estagiarios->tc) ?></td>
                                    <td><?= h($estagiarios->tc_solicitacao) ?></td>
                                    <td><?= $estagiarios->has('instituicaoestagio') ? $this->Html->link(h($estagiarios->instituicaoestagio->instituicao), ['controller' => 'instituicaoestagios', 'action' => 'view', $estagiarios->id_instituicao]) : '' ?>
                                    </td>
                                    <td><?= $estagiarios->has('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->id_supervisor]) : '' ?>
                                    </td>
                                    <td><?= $estagiarios->has('docente') ? $this->Html->link(h($estagiarios->docente->nome), ['controller' => 'docentes', 'action' => 'view', $estagiarios->id_professor]) : '' ?>
                                    </td>
                                    <td><?= h($estagiarios->periodo) ?></td>
                                    <td><?= $estagiarios->has('areaestagio') ? $this->Html->link(h($estagiarios->areaestagio->area), ['controller' => 'areaestagios', 'action' => 'view', $estagiarios->id_area]) : '' ?>
                                    </td>
                                    <td><?= h($estagiarios->nota) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                    <td><?= h($estagiarios->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiarios->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Mural de estágios') ?></h4>
                <?php if (!empty($areaestagio->muralestagios)): ?>
                    <div class="table-responsive">
                        <table class="table table-stripted table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Instituicaoestagio Id') ?></th>
                                <th><?= __('Instituicao') ?></th>
                                <th><?= __('Convenio') ?></th>
                                <th><?= __('Vagas') ?></th>
                                <th><?= __('Beneficios') ?></th>
                                <th><?= __('Final De Semana') ?></th>
                                <th><?= __('CargaHoraria') ?></th>
                                <th><?= __('Requisitos') ?></th>
                                <th><?= __('Areaestagio Id') ?></th>
                                <th><?= __('Horario') ?></th>
                                <th><?= __('Docente Id') ?></th>
                                <th><?= __('DataSelecao') ?></th>
                                <th><?= __('DataInscricao') ?></th>
                                <th><?= __('HorarioSelecao') ?></th>
                                <th><?= __('LocalSelecao') ?></th>
                                <th><?= __('FormaSelecao') ?></th>
                                <th><?= __('Contato') ?></th>
                                <th><?= __('Outras') ?></th>
                                <th><?= __('Periodo') ?></th>
                                <th><?= __('Datafax') ?></th>
                                <th><?= __('LocalInscricao') ?></th>
                                <th><?= __('Email') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                            <?php foreach ($areaestagio->muralestagios as $muralestagios): ?>
                                <tr>
                                    <td><?= h($muralestagios->id) ?></td>
                                    <td><?= h($muralestagios->id_estagio) ?></td>
                                    <td><?= $muralestagios->instituicao = ($muralestagios->id_estagio > 0) ? $this->Html->link(h($muralestagios->instituicao), ['controller' => 'instituicaoestagios', 'action' => 'view', $muralestagios->id_estagio]) : '' ?>
                                    </td>
                                    <td><?= h($muralestagios->convenio) ?></td>
                                    <td><?= h($muralestagios->vagas) ?></td>
                                    <td><?= h($muralestagios->beneficios) ?></td>
                                    <td><?= h($muralestagios->final_de_semana) ?></td>
                                    <td><?= h($muralestagios->cargaHoraria) ?></td>
                                    <td><?= h($muralestagios->requisitos) ?></td>
                                    <td><?= h($muralestagios->areaestagio_id) ?></td>
                                    <td><?= h($muralestagios->horario) ?></td>
                                    <td><?= h($muralestagios->docente_id) ?></td>
                                    <td><?= h($muralestagios->dataSelecao) ?></td>
                                    <td><?= h($muralestagios->dataInscricao) ?></td>
                                    <td><?= h($muralestagios->horarioSelecao) ?></td>
                                    <td><?= h($muralestagios->localSelecao) ?></td>
                                    <td><?= h($muralestagios->formaSelecao) ?></td>
                                    <td><?= h($muralestagios->contato) ?></td>
                                    <td><?= h($muralestagios->outras) ?></td>
                                    <td><?= h($muralestagios->periodo) ?></td>
                                    <td><?= h($muralestagios->datafax) ?></td>
                                    <td><?= h($muralestagios->localInscricao) ?></td>
                                    <td><?= h($muralestagios->email) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $muralestagios->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>