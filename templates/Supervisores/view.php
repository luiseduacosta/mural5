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
    <?= $this->Html->link(__('Editar supervisor(a)'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary float-end']) ?>
    <?= $this->Html->link(__('Listar supervisores(as)'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
    <?php if ($user['categoria_id'] == 1): ?>
        <?= $this->Html->link(__('Cadastrar supervisor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Form->postLink(__('Exclur supervisor(a)'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $supervisor->id), 'class' => 'btn btn-danger float-end']) ?>
    <?php endif; ?>

    <div class="row">
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
        </ul>
    </div>

    <div class="row">
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
                <?php if (!empty($supervisor->instituicaoestagios)): ?>
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
                            <?php foreach ($supervisor->instituicaoestagios as $instituicaoestagios): ?>
                                <tr>
                                    <td><?= h($instituicaoestagios->id) ?></td>
                                    <td><?= h($instituicaoestagios->instituicao) ?></td>
                                    <td><?= h($instituicaoestagios->cnpj) ?></td>
                                    <td><?= h($instituicaoestagios->email) ?></td>
                                    <td><?= h($instituicaoestagios->endereco) ?></td>
                                    <td><?= h($instituicaoestagios->bairro) ?></td>
                                    <td><?= h($instituicaoestagios->municipio) ?></td>
                                    <td><?= h($instituicaoestagios->cep) ?></td>
                                    <td><?= h($instituicaoestagios->telefone) ?></td>
                                    <td><?= h($instituicaoestagios->convenio) ?></td>
                                    <td><?= h($instituicaoestagios->expira) ?></td>
                                    <td><?= h($instituicaoestagios->seguro) ?></td>
                                    <td><?= h($instituicaoestagios->observacoes) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Instituicaoestagios', 'action' => 'view', $instituicaoestagios->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Instituicaoestagios', 'action' => 'edit', $instituicaoestagios->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Instituicaoestagios', 'action' => 'delete', $instituicaoestagios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instituicaoestagios->id)]) ?>
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
                                <th><?= __('Estudante') ?></th>
                                <th><?= __('Registro') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Nivel') ?></th>
                                <th><?= __('Docente') ?></th>
                                <th><?= __('Periodo') ?></th>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('Ch') ?></th>
                                <th><?= __('Observacoes') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($supervisor->estagiarios as $estagiarios): ?>
                                <tr>
                                    <td><?= h($estagiarios->id) ?></td>
                                    <td><?= $this->Html->link($estagiarios->estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $estagiarios->estudante_id]) ?>
                                    </td>
                                    <td><?= h($estagiarios->registro) ?></td>
                                    <td><?= h($estagiarios->turno) ?></td>
                                    <td><?= h($estagiarios->nivel) ?></td>
                                    <td><?= $estagiarios->hasValue('docente') ? $this->Html->link($estagiarios->docente->nome, ['controller' => 'docentes', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                    </td>
                                    <td><?= h($estagiarios->periodo) ?></td>
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
</div>