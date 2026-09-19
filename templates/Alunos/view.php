<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 page-header">
        <div>
            <h1 class="mb-1"><?= h($aluno->nome) ?></h1>
            <p class="text-muted mb-0">Dados pessoais do estudante e registros relacionados.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <?= $this->Html->link(__('Voltar'), 'javascript:history.back()', ['class' => 'btn btn-outline-secondary']) ?>
            <?php if ($user_data['categoria'] == '1') : ?>
                <?= $this->Html->link(__('Novo Aluno(a)'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Listar Alunos(as)'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
                <?= $this->Html->link(__('Editar Aluno(a)'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'declaracaoperiodo', $aluno->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'termocompromisso', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Form->postLink(__('Excluir Aluno(a)'), ['action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que deseja excluir {0}?', $aluno->nome), 'class' => 'btn btn-danger']) ?>
            <?php elseif ($user_data['aluno_id'] && ($user_data['aluno_id'] == $aluno->id)) : ?>
                <?= $this->Html->link(__('Editar Aluno(a)'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'declaracaoperiodo', $aluno->id], ['class' => 'btn btn-outline-primary']) ?>
                <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'termocompromisso', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-outline-primary']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= h($aluno->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nome') ?></th>
                        <td><?= h($aluno->nome) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nome Social') ?></th>
                        <td><?= h($aluno->nomesocial ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data de Nascimento') ?></th>
                        <td><?= h($aluno->nascimento ? $aluno->nascimento->format('d/m/Y') : 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Registro') ?></th>
                        <td><?= h($aluno->registro) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Ingresso') ?></th>
                        <td><?= h($aluno->ingresso ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Turno') ?></th>
                        <td><?= h($aluno->TurnoID->turno ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('CPF') ?></th>
                        <td><?= h($aluno->cpf) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Identidade') ?></th>
                        <td><?= h($aluno->identidade ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Orgão expedidor') ?></th>
                        <td><?= h($aluno->orgao ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('E-mail') ?></th>
                        <td><?= h($aluno->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Telefone') ?></th>
                        <td><?= h($aluno->telefone ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Celular') ?></th>
                        <td><?= h($aluno->celular ?? 's/d') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Endereço') ?></th>
                        <td><?= h(($aluno->endereco ?? 's/d') . ' - ' . ($aluno->bairro ?? 's/d') . ' - ' . ($aluno->municipio ?? 's/d') . ' - ' . ($aluno->cep ?? 's/d')) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <?php if (!empty($aluno->observacoes)) : ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3"><?= __('Observações') ?></h4>
                <div class="text-body-secondary">
                    <?= $this->Markdown->parse($aluno->observacoes); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($user_data['categoria'] === '1' && !empty($aluno->user)) : ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3"><?= __('Usuário') ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <tr>
                            <th class="actions"><?= __('Ações') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Criado') ?></th>
                            <th><?= __('Modificado') ?></th>
                        </tr>
                        <tr>
                            <td class="actions d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Users', 'action' => 'view', $aluno->user->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Users', 'action' => 'edit', $aluno->user->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Users', 'action' => 'delete', $aluno->user->id], ['confirm' => __('Tem certeza que deseja excluir user_{0}?', $aluno->user->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                            </td>
                            <td><?= $this->Html->link((string)$aluno->user->id, ['controller' => 'Users', 'action' => 'view', $aluno->user->id]) ?></td>
                            <td><?= $aluno->user->email ? $this->Text->autoLinkEmails($aluno->user->email) : '' ?></td>
                            <td><?= h($aluno->user->created ? $aluno->user->created->format('d/m/Y H:i:s') : 's/d') ?></td>
                            <td><?= h($aluno->user->modified ? $aluno->user->modified->format('d/m/Y H:i:s') : 's/d') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($aluno->inscricoes)) : ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3"><?= __('Inscrições') ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <tr>
                            <th class="actions"><?= __('Ações') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estágio') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Timestamp') ?></th>
                        </tr>
                        <?php foreach ($aluno->inscricoes as $inscricao) : ?>
                        <tr>
                            <td class="actions d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                <?php if ($user_data['categoria'] === '1') : ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscricao->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $inscricao->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $this->Html->link(h((string)$inscricao->id), ['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id]) ?></td>
                            <td><?= empty($inscricao->muralestagio->instituicao_id) ? $inscricao->muralestagio_id : $this->Html->link($inscricao->muralestagio->instituicao_entidade->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) ?></td>
                            <td><?= h($inscricao->data ? $inscricao->data->format('d/m/Y') : '') ?></td>
                            <td><?= h($inscricao->periodo) ?></td>
                            <td><?= h($inscricao->timestamp ? $inscricao->timestamp->format('d/m/Y H:i:s') : '') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($aluno->estagiarios)) : ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="mb-3"><?= __('Estágios') ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <tr>
                            <th class="actions"><?= __('Ações') ?></th>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituição') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Supervisor(a)') ?></th>
                            <th><?= __('Professor(a)') ?></th>
                            <th><?= __('Nível') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                        </tr>
                        <?php foreach ($aluno->estagiarios as $estagiario) : ?>
                        <tr>
                            <td class="actions d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                <?php if ($user_data['categoria'] === '1') : ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que deseja excluir {0}?', $estagiario->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $this->Html->link((string)$estagiario->id, ['controller' => 'Estagiarios', 'action' => 'view', $estagiario->id]) ?></td>
                            <td><?= $estagiario->instituicao ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?></td>
                            <td><?= h($estagiario->periodo) ?></td>
                            <td><?= h($estagiario->aluno->turno->turno ?? 's/d') ?></td>
                            <td><?= ($estagiario->supervisor and $estagiario->supervisor->nome) ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?></td>
                            <td><?= $estagiario->professor ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?></td>
                            <td><?= h($estagiario->nivel) ?></td>
                            <td><?= h($estagiario->nota) ?></td>
                            <td><?= h($estagiario->ch) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
