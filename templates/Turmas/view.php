<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turma $turma
 */
declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => '0'];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
            <li class="nav-item">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
            </li>
            <?php if ($user_data['administrador_id']): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar turma'), ['action' => 'edit', $turma->id], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir turma'), ['action' => 'delete', $turma->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $turma->id), 'class' => 'btn btn-danger me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova turma'), ['action' => 'add'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

    <div class="container">
        <h3><?= h($turma->turma) ?></h3>
        <table class="table table-stripted table-hover table-responsive">
            <tr>
                <th><?= __('Turma') ?></th>
                <td><?= h($turma->turma) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $turma->id ?></td>
            </tr>
        </table>
        <div class="related">
            <h4><?= __('Estagiários') ?></h4>
            <?php if (!empty($turma->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-stripted table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajuste 2020') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitacao') ?></th>
                            <th><?= __('Instituição') ?></th>
                            <th><?= __('Supervisor') ?></th>
                            <th><?= __('Professor') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <?php if ($user_data['administrador_id']): ?>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('Ch') ?></th>
                            <?php endif; ?>
                            <?php if ($user_data['administrador_id']): ?>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($turma->estagiarios as $estagiarios): ?>
                            <tr>
                                <td><?= h($estagiarios->id) ?></td>
                                <?php if ($user_data['administrador_id']): ?>
                                    <td><?= $estagiarios->hasValue('aluno') ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                                <?php endif; ?>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->tc) ?></td>
                                <td><?= h($estagiarios->tc_solicitacao) ?></td>
                                <td><?= $estagiarios->hasValue('instituicao') ? $this->Html->link(h($estagiarios->instituicao->instituicao), ['controller' => 'instituicoes', 'action' => 'view', $estagiarios->instituicao_id]) : '' ?></td>
                                <?php if ($user_data['administrador_id']): ?>
                                    <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                <?php endif; ?>
                                <?php if ($user_data['administrador_id']): ?>
                                    <td><?= $estagiarios->hasValue('professor') ? $this->Html->link(h($estagiarios->professor->nome), ['controller' => 'professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('professor') ? $estagiarios->professor->nome : '' ?></td>
                                <?php endif; ?>
                                <td><?= h($estagiarios->periodo) ?></td>
                                <?php if ($user_data['administrador_id']): ?>
                                    <td><?= h($estagiarios->nota) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                <?php endif; ?>

                                <td class="actions">
                                    <?php if ($user_data['administrador_id']): ?>
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiarios->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <div class="related">
            <h4><?= __('Mural de estágios') ?></h4>
            <?php if (!empty($turma->muralestagios)): ?>
                <div class="table-responsive">
                    <table class="table table-stripted table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicao Id') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Convenio') ?></th>
                            <th><?= __('Vagas') ?></th>
                            <th><?= __('Beneficios') ?></th>
                            <th><?= __('Final De Semana') ?></th>
                            <th><?= __('Carga horaria') ?></th>
                            <th><?= __('Requisitos') ?></th>
                            <th><?= __('Horário do estágio') ?></th>
                            <th><?= __('Data inscricao') ?></th>
                            <th><?= __('Local inscricao') ?></th> 
                            <th><?= __('Data selecao') ?></th>
                            <th><?= __('Horario selecao') ?></th>
                            <th><?= __('Forma selecao') ?></th>
                            <th><?= __('Contato') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Email') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($turma->muralestagios as $muralestagios): ?>
                            <tr>
                                <td><?= h($muralestagios->id) ?></td>
                                <td><?= h($muralestagios->instituicao_id) ?></td>
                                <td><?= $muralestagios->hasValue('instituicao') ? $this->Html->link(h($muralestagios->instituicao), ['controller' => 'instituicoes', 'action' => 'view', $muralestagios->instituicao_id]) : '' ?>
                                </td>
                                <td><?= h($muralestagios->convenio) ?></td>
                                <td><?= h($muralestagios->vagas) ?></td>
                                <td><?= h($muralestagios->beneficios) ?></td>
                                <td><?= h($muralestagios->final_de_semana) ?></td>
                                <td><?= h($muralestagios->carga_horaria) ?></td>
                                <td><?= h($muralestagios->requisitos) ?></td>
                                <td><?= h($muralestagios->horario) ?></td>
                                <td><?= h($muralestagios->data_inscricao) ?></td>
                                <td><?= h($muralestagios->local_inscricao) ?></td>
                                <td><?= h($muralestagios->data_selecao) ?></td>
                                <td><?= h($muralestagios->horario_selecao) ?></td>
                                <td><?= h($muralestagios->forma_selecao) ?></td>
                                <td><?= h($muralestagios->contato) ?></td>
                                <td><?= h($muralestagios->periodo) ?></td>
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