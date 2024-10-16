<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($supervisor);
// die();
?>
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">

                <?php if ($user->categoria_id == 1): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar supervisores(as)'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar supervisor(a)'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Cadastrar supervisor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir supervisor(a)'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $supervisor->id), 'class' => 'btn btn-danger float-end']) ?>
                    </li>
                <?php endif; ?>
                <?php if ($user->categoria_id == 4): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar supervisor(a)'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#supervisora" role="tab"
                    aria-controls="supervisora" aria-selected="true">Supervisora</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#instituicao" role="tab" aria-controls="instituicao"
                    aria-selected="false">Instituição</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                    aria-selected="false">Estagiários</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#avaliacoes" role="tab" aria-controls="avaliacoes"
                    aria-selected="false">Avaliações</a>
            </li>
        </ul>

        <div class="container">
            <div class="tab-content">

                <div id="supervisora" class="tab-pane container active show">
                    <h3><?= h($supervisor->nome) ?></h3>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= $supervisor->id ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Cress') ?></th>
                            <td><?= $supervisor->cress ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Regiao') ?></th>
                            <td><?= $this->Number->format($supervisor->regiao) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Nome') ?></th>
                            <td><?= h($supervisor->nome) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Cpf') ?></th>
                            <td><?= h($supervisor->cpf) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Cep') ?></th>
                            <td><?= h($supervisor->cep) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Endereco') ?></th>
                            <td><?= h($supervisor->endereco) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Bairro') ?></th>
                            <td><?= h($supervisor->bairro) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Municipio') ?></th>
                            <td><?= h($supervisor->municipio) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($supervisor->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('DDD') ?></th>
                            <td><?= h($supervisor->codigo_tel) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Telefone') ?></th>
                            <td><?= h($supervisor->telefone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('DDD') ?></th>
                            <td><?= h($supervisor->codigo_cel) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Celular') ?></th>
                            <td><?= h($supervisor->celular) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Escola') ?></th>
                            <td><?= h($supervisor->escola) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Ano Formatura') ?></th>
                            <td><?= h($supervisor->ano_formatura) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Outros Estudos') ?></th>
                            <td><?= h($supervisor->outros_estudos) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Area Curso') ?></th>
                            <td><?= h($supervisor->area_curso) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Ano Curso') ?></th>
                            <td><?= h($supervisor->ano_curso) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Cargo') ?></th>
                            <td><?= h($supervisor->cargo) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Curso Turma') ?></th>
                            <td><?= h($supervisor->curso_turma) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Num Inscricao') ?></th>
                            <td><?= $supervisor->num_inscricao ?></td>
                        </tr>
                    </table>
                    <div class="text">
                        <strong><?= __('Observações') ?></strong>
                        <blockquote>
                            <?= $this->Text->autoParagraph(h($supervisor->observacoes)); ?>
                        </blockquote>
                    </div>
                </div>

                <div id="instituicao" class="tab-pane container fade">
                    <h4><?= __('Instituição de estágio') ?></h4>
                    <?php if (!empty($supervisor->instituicoes)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Instituicao') ?></th>
                                    <th><?= __('Cnpj') ?></th>
                                    <th><?= __('Email') ?></th>
                                    <th><?= __('Endereco') ?></th>
                                    <th><?= __('Bairro') ?></th>
                                    <th><?= __('Municipio') ?></th>
                                    <th><?= __('Cep') ?></th>
                                    <th><?= __('Telefone') ?></th>
                                    <th><?= __('Convenio') ?></th>
                                    <th><?= __('Expira') ?></th>
                                    <th><?= __('Seguro') ?></th>
                                    <th><?= __('Observacoes') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                                <?php foreach ($supervisor->instituicoes as $instituicoes): ?>
                                    <tr>
                                        <td><?= h($instituicoes->id) ?></td>
                                        <td><?= h($instituicoes->instituicao) ?></td>
                                        <td><?= h($instituicoes->cnpj) ?></td>
                                        <td><?= h($instituicoes->email) ?></td>
                                        <td><?= h($instituicoes->endereco) ?></td>
                                        <td><?= h($instituicoes->bairro) ?></td>
                                        <td><?= h($instituicoes->municipio) ?></td>
                                        <td><?= h($instituicoes->cep) ?></td>
                                        <td><?= h($instituicoes->telefone) ?></td>
                                        <td><?= h($instituicoes->convenio) ?></td>
                                        <td><?= h($instituicoes->expira) ?></td>
                                        <td><?= h($instituicoes->seguro) ?></td>
                                        <td><?= h($instituicoes->observacoes) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Instituicoes', 'action' => 'view', $instituicoes->id]) ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Instituicoes', 'action' => 'edit', $instituicoes->id]) ?>
                                            <?php if ($user->categoria_id == 1): ?>
                                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Instituicoes', 'action' => 'delete', $instituicoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $instituicoes->id)]) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="estagiarios" class="tab-pane container fade">
                    <h4><?= __('Estagiarios') ?></h4>
                    <?php if (!empty($supervisor->estagiarios)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Aluno') ?></th>
                                    <th><?= __('Registro') ?></th>
                                    <th><?= __('Turno') ?></th>
                                    <th><?= __('Nivel') ?></th>
                                    <th><?= __('Professor') ?></th>
                                    <th><?= __('Periodo') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('Ch') ?></th>
                                    <th><?= __('Observacoes') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($supervisor->estagiarios as $estagiarios): ?>
                                    <tr>
                                        <td><?= h($estagiarios->id) ?></td>
                                        <td><?= $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) ?>
                                        </td>
                                        <td><?= h($estagiarios->registro) ?></td>
                                        <td><?= h($estagiarios->turno) ?></td>
                                        <td><?= h($estagiarios->nivel) ?></td>
                                        <td><?= $estagiarios->hasValue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
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

                <div id="avaliacoes" class="tab-pane container fade">
                    <h4><?= __('Avaliações') ?></h4>
                    <?php if (!empty($supervisor->estagiarios)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Aluno') ?></th>
                                    <th><?= __('Registro') ?></th>
                                    <th><?= __('Turno') ?></th>
                                    <th><?= __('Nivel') ?></th>
                                    <th><?= __('Professor') ?></th>
                                    <th><?= __('Periodo') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('Carga horária') ?></th>
                                    <th><?= __('Avaliação') ?></th>
                                    <th><?= __('Observacoes') ?></th>
                                </tr>
                                <?php foreach ($supervisor->estagiarios as $estagiarios): ?>
                                    <tr>
                                        <td><?= h($estagiarios->id) ?></td>
                                        <td><?= $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) ?>
                                        </td>
                                        <td><?= h($estagiarios->registro) ?></td>
                                        <td><?= h($estagiarios->turno) ?></td>
                                        <td><?= h($estagiarios->nivel) ?></td>
                                        <td><?= $estagiarios->hasValue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                        </td>
                                        <td><?= h($estagiarios->periodo) ?></td>
                                        <td><?= h($estagiarios->nota) ?></td>
                                        <td><?= h($estagiarios->ch) ?></td>
                                        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 4): ?>
                                            <td><?= $estagiarios->hasValue('avaliacao') ? $this->Html->link('Avaliação do(a) estagiario(a)', ['controller' => 'avaliacoes', 'action' => 'view', '?' => ['estagiario_id' => $estagiarios->id]]) : $this->Html->link('Avaliar discente', ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $estagiarios->id]]) ?>
                                            </td>
                                        <?php else: ?>
                                            <td><?= $estagiarios->hasValue('avaliacao') ? $this->Html->link('Avaliação do(a) estagiário(a)', ['controller' => 'avaliacoes', 'action' => 'view', '?' => ['estagiario_id' => $estagiarios->id]]) : " " ?>
                                            </td>
                                        <?php endif; ?>
                                        <td><?= h($estagiarios->observacoes) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>