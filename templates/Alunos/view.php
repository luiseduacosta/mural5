<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
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

                    <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">

                    <?= $this->Html->link(__('Editar Aluno'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">

                    <?= $this->Html->link(__('Listar Alunos'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">

                    <?= $this->Form->postLink(__('Excluir Aluno'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id), 'class' => 'btn btn-danger float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= h($aluno->nome) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $aluno->id ?></td>
            </tr>
            <tr>
                <th><?= __('Registro') ?></th>
                <td><?= $aluno->registro ?></td>
            </tr>
            <tr>
                <th><?= __('Nome') ?></th>
                <td><?= h($aluno->nome) ?></td>
            </tr>
            <tr>
                <th><?= __('Nascimento') ?></th>
                <td><?= date('d-m-Y', strtotime(h($aluno->nascimento))) ?></td>
            </tr>
            <tr>
                <th><?= __('Cpf') ?></th>
                <td><?= h($aluno->cpf) ?></td>
            </tr>
            <tr>
                <th><?= __('Identidade') ?></th>
                <td><?= h($aluno->identidade) ?></td>
            </tr>
            <tr>
                <th><?= __('Orgao') ?></th>
                <td><?= h($aluno->orgao) ?></td>
            </tr>
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($aluno->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Codigo Telefone') ?></th>
                <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
            </tr>
            <tr>
                <th><?= __('Telefone') ?></th>
                <td><?= h($aluno->telefone) ?></td>
            </tr>
            <tr>
                <th><?= __('Codigo Celular') ?></th>
                <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
            </tr>
            <tr>
                <th><?= __('Celular') ?></th>
                <td><?= h($aluno->celular) ?></td>
            </tr>
            <tr>
                <th><?= __('Cep') ?></th>
                <td><?= h($aluno->cep) ?></td>
            </tr>
            <tr>
                <th><?= __('Endereco') ?></th>
                <td><?= h($aluno->endereco) ?></td>
            </tr>
            <tr>
                <th><?= __('Municipio') ?></th>
                <td><?= h($aluno->municipio) ?></td>
            </tr>
            <tr>
                <th><?= __('Bairro') ?></th>
                <td><?= h($aluno->bairro) ?></td>
            </tr>
            <tr>
                <th><?= __('Observações') ?></th>
                <td><?= h($aluno->observacoes) ?></td>
            </tr>
        </table>

        <div class="container">
            <h4><?= __('Inscrições para seleção de estágio') ?></h4>
            <?php if (!empty($aluno->inscricoes)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Muralestagio') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Timestamp') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($aluno->inscricoes as $inscricoes): ?>
                            <tr>
                                <td><?= h($inscricoes->id) ?></td>
                                <td><?= h($inscricoes->registro) ?></td>
                                <td><?= h($inscricoes->estudante_id) ?></td>
                                <td><?= $inscricoes->hasValue('muralestagio') ? $this->Html->link($inscricoes->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricoes->instituicaoestagio_id]) : '' ?>
                                </td>
                                <td><?= date('d-m-Y', strtotime(h($inscricoes->data))) ?></td>
                                <td><?= h($inscricoes->periodo) ?></td>
                                <td><?= date('d-m-Y', strtotime(h($inscricoes->timestamp))) ?></td>

                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricoes->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscricoes->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscricoes->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="container">
            <h4><?= __('Estágios cursados') ?></h4>
            <?php if (!empty($aluno->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estagiario') ?></th>
                            <th><?= __('Ajuste 2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitação') ?></th>
                            <th><?= __('Instituição de estagio') ?></th>
                            <th><?= __('Supervisor') ?></th>
                            <th><?= __('Professor') ?></th>
                            <th><?= __('Àrea de estágio') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                            <th><?= __('Observações') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($aluno->estagiarios as $estagiarios): ?>
                            <tr>
                                <?php // pr($estagiarios); ?>
                                <td><?= h($estagiarios->id) ?></td>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= h($estagiarios->tc) ?></td>
                                <td><?= date('d-m-Y', strtotime(h($estagiarios->tc_solicitacao))) ?></td>
                                <td><?= $estagiarios->hasValue('instituicaoestagio') ? $this->Html->link($estagiarios->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiarios->instituicaoestagio_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasValue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasValue('turmaestagio') ? h($estagiarios->turmaestagio->area) : '' ?>
                                </td>
                                <td><?= h($estagiarios->nota) ?></td>
                                <td><?= h($estagiarios->ch) ?></td>
                                <td><?= h($estagiarios->observacoes) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>