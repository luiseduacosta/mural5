<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>
<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="mb-0"><?= h($supervisor->nome) ?></h3>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <?php if ($user_data['categoria'] === '1'): ?>
                <?= $this->Html->link(__('Listar supervisores(as)'), ['action' => 'index'], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Html->link(__('Editar supervisor(a)'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Cadastrar supervisor(a)'), ['action' => 'add'], ['class' => 'btn btn-success']) ?>
                <?= $this->Form->postLink(__('Excluir supervisor(a)'), ['action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $supervisor->id), 'class' => 'btn btn-danger']) ?>
            <?php endif; ?>
            <?php if ($user_data['supervisor_id']): ?>
                <?= $this->Html->link(__('Editar supervisor(a)'), ['action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <ul class="nav nav-tabs px-3 pt-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#supervisora" type="button" role="tab" aria-controls="supervisora" aria-selected="true">Supervisora</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#instituicao" type="button" role="tab" aria-controls="instituicao" aria-selected="false">Instituição</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#estagiarios" type="button" role="tab" aria-controls="estagiarios" aria-selected="false">Estagiários</button>
                </li>
            </ul>

            <div class="tab-content p-3">
                <div id="supervisora" class="tab-pane fade show active" role="tabpanel">
                    <table class="table table-striped table-hover mb-0">
                        <tr><th><?= __('Id') ?></th><td><?= $supervisor->id ?></td></tr>
                        <tr><th><?= __('Cress') ?></th><td><?= $supervisor->cress ?></td></tr>
                        <tr><th><?= __('Regiao') ?></th><td><?= $this->Number->format($supervisor->regiao) ?></td></tr>
                        <tr><th><?= __('Nome') ?></th><td><?= h($supervisor->nome) ?></td></tr>
                        <tr><th><?= __('CPF') ?></th><td><?= h($supervisor->cpf) ?></td></tr>
                        <tr><th><?= __('CEP') ?></th><td><?= h($supervisor->cep) ?></td></tr>
                        <tr><th><?= __('Endereço') ?></th><td><?= h($supervisor->endereco) ?></td></tr>
                        <tr><th><?= __('Bairro') ?></th><td><?= h($supervisor->bairro) ?></td></tr>
                        <tr><th><?= __('Município') ?></th><td><?= h($supervisor->municipio) ?></td></tr>
                        <tr><th><?= __('Email') ?></th><td><?= h($supervisor->email) ?></td></tr>
                        <tr><th><?= __('Telefone') ?></th><td><?= h($supervisor->telefone) ?></td></tr>
                        <tr><th><?= __('Celular') ?></th><td><?= h($supervisor->celular) ?></td></tr>
                        <tr><th><?= __('Escola') ?></th><td><?= h($supervisor->escola) ?></td></tr>
                        <tr><th><?= __('Ano Formatura') ?></th><td><?= h($supervisor->ano_formatura) ?></td></tr>
                        <tr><th><?= __('Cargo') ?></th><td><?= h($supervisor->cargo) ?></td></tr>
                    </table>
                    <div class="mt-4">
                        <h5><?= __('Observações') ?></h5>
                        <div class="border rounded p-3 bg-light">
                            <?= $this->Text->autoParagraph(h($supervisor->observacoes)); ?>
                        </div>
                    </div>
                </div>

                <div id="instituicao" class="tab-pane fade" role="tabpanel">
                    <h4><?= __('Instituição de estágio') ?></h4>
                    <?php if (!empty($supervisor->instituicoes)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Instituição') ?></th>
                                    <th><?= __('CNPJ') ?></th>
                                    <th><?= __('Email') ?></th>
                                    <th><?= __('Telefone') ?></th>
                                    <th><?= __('Convênio') ?></th>
                                    <th><?= __('Expira') ?></th>
                                    <th><?= __('Seguro') ?></th>
                                    <th><?= __('Observações') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                                <?php foreach ($supervisor->instituicoes as $instituicoes): ?>
                                    <tr>
                                        <td><?= h($instituicoes->id) ?></td>
                                        <td><?= $this->Html->link($instituicoes->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicoes->id]) ?></td>
                                        <td><?= h($instituicoes->cnpj) ?></td>
                                        <td><?= h($instituicoes->email) ?></td>
                                        <td><?= h($instituicoes->telefone) ?></td>
                                        <td><?= h($instituicoes->convenio) ?></td>
                                        <td><?= h($instituicoes->expira) ?></td>
                                        <td><?= h($instituicoes->seguro) ?></td>
                                        <td><?= h($instituicoes->observacoes) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Instituicoes', 'action' => 'view', $instituicoes->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Instituicoes', 'action' => 'edit', $instituicoes->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                            <?php if ($user_data['categoria'] === '1'): ?>
                                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Instituicoes', 'action' => 'delete', $instituicoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $instituicoes->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="estagiarios" class="tab-pane fade" role="tabpanel">
                    <h4><?= __('Estagiários') ?></h4>
                    <?php if (isset($supervisor->estagiarios)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <th><?= __('Aluno') ?></th>
                                    <th><?= __('Registro') ?></th>
                                    <th><?= __('Turno') ?></th>
                                    <th><?= __('Nível') ?></th>
                                    <th><?= __('Professor') ?></th>
                                    <th><?= __('Período') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                                <?php foreach ($supervisor->estagiarios as $estagiarios): ?>
                                    <tr>
                                        <td><?= h($estagiarios->id) ?></td>
                                        <td><?= $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) ?></td>
                                        <td><?= h($estagiarios->registro) ?></td>
                                        <td><?= h($estagiarios->aluno->turno) ?></td>
                                        <td><?= h($estagiarios->nivel) ?></td>
                                        <td><?= $estagiarios->hasValue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?></td>
                                        <td><?= h($estagiarios->periodo) ?></td>
                                        <td><?= h($estagiarios->nota) ?></td>
                                        <td><?= h($estagiarios->ch) ?></td>
                                        <td class="actions">
                                            <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                            <?php endif; ?>
                                            <?php if ($user_data['categoria'] === '1'): ?>
                                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                            <?php endif; ?>
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
</div>
