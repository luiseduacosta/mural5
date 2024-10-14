<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
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
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar turma de estágio'), ['action' => 'edit', $turmaestagio->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir turma de estágio'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar turma de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova turma de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= h($turmaestagio->area) ?></h3>
        <table class="table table-stripted table-hover table-responsive">
            <tr>
                <th><?= __('Turma de estágio') ?></th>
                <td><?= h($turmaestagio->area) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $turmaestagio->id ?></td>
            </tr>
        </table>
        <div class="related">
            <h4><?= __('Estagiários') ?></h4>
            <?php if (!empty($turmaestagio->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-stripted table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno') ?></th>
                            <th><?= __('Aluno') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajuste curricular 2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitacao') ?></th>
                            <th><?= __('Instituicaoestagio') ?></th>
                            <th><?= __('Supervisor') ?></th>
                            <th><?= __('Professor') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Turmaestagio') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('Ch') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($turmaestagio->estagiarios as $estagiarios): ?>
                            <tr>
                                <?php // pr($estagiarios); ?>
                                <?php // die(); ?>
                                <td><?= h($estagiarios->id) ?></td>
                                <td><?= $estagiarios->hasValue('aluno') ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasValue('aluno') ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?>
                                </td>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->tc) ?></td>
                                <td><?= h($estagiarios->tc_solicitacao) ?></td>
                                <td><?= $estagiarios->hasValue('instituicao') ? $this->Html->link(h($estagiarios->instituicao->instituicao), ['controller' => 'instituicoes', 'action' => 'view', $estagiarios->instituicao_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasValue('professor') ? $this->Html->link(h($estagiarios->professor->nome), ['controller' => 'professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                </td>
                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= $estagiarios->hasValue('turmaestagio') ? $this->Html->link(h($estagiarios->turmaestagio->area), ['controller' => 'turmaestagios', 'action' => 'view', $estagiarios->turmaestagio_id]) : '' ?>
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
            <?php if (!empty($turmaestagio->muralestagios)): ?>
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
                            <th><?= __('Turmaestagio Id') ?></th>
                            <th><?= __('Horario') ?></th>
                            <th><?= __('Professor') ?></th>
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
                        <?php foreach ($turmaestagio->muralestagios as $muralestagios): ?>
                            <tr>
                                <td><?= h($muralestagios->id) ?></td>
                                <td><?= h($muralestagios->instituicao_id) ?></td>
                                <td><?= $muralestagios->hasValue('instituicao') ? $this->Html->link(h($muralestagios->instituicao), ['controller' => 'instituicoes', 'action' => 'view', $muralestagios->instituicao_id]) : '' ?>
                                </td>
                                <td><?= h($muralestagios->convenio) ?></td>
                                <td><?= h($muralestagios->vagas) ?></td>
                                <td><?= h($muralestagios->beneficios) ?></td>
                                <td><?= h($muralestagios->final_de_semana) ?></td>
                                <td><?= h($muralestagios->cargaHoraria) ?></td>
                                <td><?= h($muralestagios->requisitos) ?></td>
                                <td><?= h($muralestagios->turmaestagio_id) ?></td>
                                <td><?= h($muralestagios->horario) ?></td>
                                <td><?= h($muralestagios->professor_id) ?></td>
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