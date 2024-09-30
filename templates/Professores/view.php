<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Professor'), ['action' => 'edit', $professor->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Professor'), ['action' => 'delete', $professor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $professor->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Professores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Professor'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="professores view content">
            <h3><?= h($professor->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($professor->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($professor->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Localnascimento') ?></th>
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
                    <th><?= __('Email') ?></th>
                    <td><?= h($professor->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Homepage') ?></th>
                    <td><?= h($professor->homepage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Redesocial') ?></th>
                    <td><?= h($professor->redesocial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculolattes') ?></th>
                    <td><?= h($professor->curriculolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curriculosigma') ?></th>
                    <td><?= h($professor->curriculosigma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pesquisadordgp') ?></th>
                    <td><?= h($professor->pesquisadordgp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formacaoprofissional') ?></th>
                    <td><?= h($professor->formacaoprofissional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Universidadedegraduacao') ?></th>
                    <td><?= h($professor->universidadedegraduacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestradoarea') ?></th>
                    <td><?= h($professor->mestradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestradouniversidade') ?></th>
                    <td><?= h($professor->mestradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutoradoarea') ?></th>
                    <td><?= h($professor->doutoradoarea) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutoradouniversidade') ?></th>
                    <td><?= h($professor->doutoradouniversidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formaingresso') ?></th>
                    <td><?= h($professor->formaingresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipocargo') ?></th>
                    <td><?= h($professor->tipocargo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= h($professor->categoria) ?></td>
                </tr>
                <tr>
                    <th><?= __('Regimetrabalho') ?></th>
                    <td><?= h($professor->regimetrabalho) ?></td>
                </tr>
                <tr>
                    <th><?= __('Departamento') ?></th>
                    <td><?= h($professor->departamento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivoegresso') ?></th>
                    <td><?= h($professor->motivoegresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($professor->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Siape') ?></th>
                    <td><?= $this->Number->format($professor->siape) ?></td>
                </tr>
                <tr>
                    <th><?= __('Anoformacao') ?></th>
                    <td><?= $this->Number->format($professor->anoformacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mestradoanoconclusao') ?></th>
                    <td><?= $this->Number->format($professor->mestradoanoconclusao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doutoradoanoconclusao') ?></th>
                    <td><?= $this->Number->format($professor->doutoradoanoconclusao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Datanascimento') ?></th>
                    <td><?= h($professor->datanascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Atualizacaolattes') ?></th>
                    <td><?= h($professor->atualizacaolattes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dataingresso') ?></th>
                    <td><?= h($professor->dataingresso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dataegresso') ?></th>
                    <td><?= h($professor->dataegresso) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observacoes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($professor->observacoes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Estagiarios') ?></h4>
                <?php if (!empty($professor->estagiarios)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Ajustecurricular2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitacao') ?></th>
                            <th><?= __('Instituicaoestagio Id') ?></th>
                            <th><?= __('Supervisor Id') ?></th>
                            <th><?= __('Professor Id') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Areaestagio Id') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('Ch') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($professor->estagiarios as $estagiarios) : ?>
                        <tr>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= h($estagiarios->aluno_id) ?></td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->ajustecurricular2020) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <td><?= h($estagiarios->tc) ?></td>
                            <td><?= h($estagiarios->tc_solicitacao) ?></td>
                            <td><?= h($estagiarios->instituicaoestagio_id) ?></td>
                            <td><?= h($estagiarios->supervisor_id) ?></td>
                            <td><?= h($estagiarios->professor_id) ?></td>
                            <td><?= h($estagiarios->periodo) ?></td>
                            <td><?= h($estagiarios->areaestagio_id) ?></td>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Muralestagios') ?></h4>
                <?php if (!empty($professor->muralestagios)) : ?>
                <div class="table-responsive">
                    <table>
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
                            <th><?= __('Professor Id') ?></th>
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
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($professor->muralestagios as $muralestagios) : ?>
                        <tr>
                            <td><?= h($muralestagios->id) ?></td>
                            <td><?= h($muralestagios->instituicaoestagio_id) ?></td>
                            <td><?= h($muralestagios->instituicao) ?></td>
                            <td><?= h($muralestagios->convenio) ?></td>
                            <td><?= h($muralestagios->vagas) ?></td>
                            <td><?= h($muralestagios->beneficios) ?></td>
                            <td><?= h($muralestagios->final_de_semana) ?></td>
                            <td><?= h($muralestagios->cargaHoraria) ?></td>
                            <td><?= h($muralestagios->requisitos) ?></td>
                            <td><?= h($muralestagios->areaestagio_id) ?></td>
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
                                <?= $this->Html->link(__('View'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagios->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($professor->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Categoria') ?></th>
                            <th><?= __('Numero') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Supervisor Id') ?></th>
                            <th><?= __('Professor Id') ?></th>
                            <th><?= __('Timestamp') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($professor->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->categoria) ?></td>
                            <td><?= h($users->numero) ?></td>
                            <td><?= h($users->aluno_id) ?></td>
                            <td><?= h($users->supervisor_id) ?></td>
                            <td><?= h($users->professor_id) ?></td>
                            <td><?= h($users->timestamp) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
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
