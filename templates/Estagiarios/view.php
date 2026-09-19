<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiarios
 * @var \App\Model\Entity\Aluno $alunos
 */
declare(strict_types=1);
$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($user_data['categoria'] == '1'): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Declaração'), ['controller' => 'estagiarios', 'action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-info me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('PDF'), ['controller' => 'estagiarios', 'action' => 'termodecompromissopdf', $estagiario->id], ['class' => 'btn btn-info me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Inserir Estagiario'), ['action' => 'add', '?' => ['aluno_id' => $estagiario->aluno_id]], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item active">
                        <?= $this->Form->postLink(__('Excluir Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>

                <?php if ($user_data['aluno_id']): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'estagiarios', 'action' => 'termodecompromisso', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('PDF'), ['controller' => 'estagiarios', 'action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-info me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>

                <!-- Professor pode lançar notas -->
                <?php if ($user_data['professor_id']): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>

                <?php if ($user_data['aluno_id']): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'estagiarios', 'action' => 'termodecompromisso', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:180px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Declaração de estágio'), ['action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:180px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Preenche Atividades'), ['controller' => 'folhadeatividades', 'action' => 'index', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:180px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprime Atividades'), ['controller' => 'folhadeatividades', 'action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:150px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprime folha de atividades'), ['controller' => 'estagiarios', 'action' => 'folhadeatividadespdf', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:200px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprime Avaliação'), ['action' => 'avaliacaodiscentepdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:150px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>

                <?php if ($user_data['categoria'] === '1' || $user_data['supervisor_id']): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Preencher Avaliação'), ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary me-2', 'style' => 'max-width:150px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#estagiario" id="estagiario-tab" role="tab" aria-controls="estagiario" aria-selected="true">Estagiario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#atividades" id="atividades-tab" role="tab" aria-controls="atividadesfolhadeatividade-tab" role="tab" aria-controls="folhadeatividade" aria-selected="false">Folha de atividades</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#avaliacao" id="avaliacao-tab" role="tab" aria-controls="avaliacao" aria-selected="true">Avaliação</a>
        </li>
    </ul>

    <div class="tab-content">

        <div id="estagiario" class="tab-pane fade show active" role="tabpanel" aria-labelledby="estagiario-tab">
            <h3><?= h($estagiario->aluno->nome) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $estagiario->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $estagiario->registro ?></td>
                </tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <?php if ($user_data['categoria'] === '1'): ?>
                        <td><?= (isset($estagiario->aluno)) ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('aluno') ? $estagiario->aluno->nome : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Ajuste 2020') ?></th>
                    <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                </tr>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= h($estagiario->aluno?->TurnoID?->turno ?? '') ?></td>
                </tr>
                <tr>
                    <th><?= __('Nível') ?></th>
                    <td><?= h($estagiario->nivel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <?php if ($user_data['categoria'] === '1'): ?>
                        <td><?= $estagiario->hasValue('instituicao') ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('instituicao') ? $estagiario->instituicao->instituicao : '' ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Supervisor(a)') ?></th>
                    <?php if ($user_data['categoria'] === '1'): ?>
                        <td><?= $estagiario->hasValue('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('supervisor') ? $estagiario->supervisor->nome : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <?php if ($user_data['categoria'] === '1'): ?>
                        <td><?= $estagiario->hasValue('professor') ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('professor') ? $estagiario->professor->nome : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Período') ?></th>
                    <td><?= h($estagiario->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data solicitação do TC') ?></th>
                    <td><?= $estagiario->tc_solicitacao ? $estagiario->tc_solicitacao : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('TC assinado') ?></th>
                    <td><?= $estagiario->tc == '1' ? 'Sim' : 'Não' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo de estágio (Pandemia)') ?></th>
                    <td><?= $estagiario->complemento_id ?></td>
                </tr>
                <tr>
                    <th><?= __('Nota') ?></th>
                    <?php if ($estagiario->nota): ?>
                        <td><?= $this->Number->format($estagiario->nota, ['places' => 2]) ?></td>
                    <?php else: ?>
                        <td>Sem nota</td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Carga horária') ?></th>
                    <td><?= $this->Number->format($estagiario->ch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td name='observacoes'><?= h($estagiario->observacoes) ?></td>
                </tr>
            </table>
        </div>

        <div class="tab-content">
            <div id="atividades" class="tab-pane container">
                <?php if (empty($estagiario->folhadeatividades)): ?>
                    <div class="alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Este estagiário ainda não possui atividades cadastradas.</p>
                        <hr>
                        <p class="mb-0">Clique no botão
                            <?= $this->Html->link(
                                "Preencher Atividades",
                                ['controller' => 'folhadeatividades', 'action' => 'atividade', '?' => ['estagiario_id' => $estagiario->id]],
                                ['class' => 'btn btn-sm btn-primary me-1']
                            ) ?>
                            para adicionar atividades.
                        </p>
                    </div>
                <?php else: ?>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __("Id") ?></th>
                            <th><?= __("Dia") ?></th>
                            <th><?= __("Início") ?></th>
                            <th><?= __("Final") ?></th>
                            <th><?= __("Atividade") ?></th>
                            <th><?= __("Horário") ?></th>
                        </tr>
                        <?php foreach (
                            $estagiario->folhadeatividades
                            as $folhadeatividade
                        ): ?>
                            <tr>
                                <td><?= h($folhadeatividade->id) ?></td>
                                <td>
                                    <?=
                                        $this->Time->format($folhadeatividade->dia, "d-MM-Y")
                                        ?>
                                </td>
                                <td>
                                    <?=
                                        $folhadeatividade->inicio ? $folhadeatividade->inicio->format('H:i') : ''
                                        ?>
                                </td>
                                <td>
                                    <?=
                                        $folhadeatividade->final ? $folhadeatividade->final->format('H:i') : ''
                                        ?>
                                </td>
                                <td class="text">
                                    <?= $this->Text->autoParagraph(
                                        h($folhadeatividade->atividade),
                                    ) ?>
                                </td>
                                <td><?= h($folhadeatividade->horario) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="avaliacao" class="tab-pane container">
                <?php if (empty($estagiario->resposta)): ?>
                    <div class="alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Este estagiário ainda não possui avaliação.</p>
                        <hr>
                        <?php if ($user_data['categoria'] === '1'): ?>
                            <p class="mb-0">Clique no botão para
                                <?= $this->Html->link(
                                    "imprimir",
                                    ['controller' => 'respostas', 'action' => 'imprimeresposta', '?' => ['estagiario_id' => $estagiario->id]],
                                    ['class' => 'btn btn-sm btn-info me-1']
                                ) ?>
                                uma folha de avaliação.
                            </p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <td colspan="3">
                                <strong><?= __("Avaliação") ?></strong>
                            </td>
                        </tr>
                        <?php $avaliacoes = json_decode($estagiario->resposta->response, true); ?>
                        <?php foreach ($avaliacoes as $avaliacao): ?>
                            <?php if (is_string($avaliacao)) { ?>
                                <tr>
                                    <td colspan="3"><?php // h($avaliacao) ?></td>
                                </tr>
                            <?php } elseif (is_array($avaliacao)) { ?>
                                <tr>
                                    <td><?= h($avaliacao['pergunta']) ?></td>
                                    <td><?= h($avaliacao['valor']) ?></td>
                                    <td><?= h($avaliacao['texto_valor']) ?></td>
                                </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        </table>
                        <div class="row">
                            <div class="col-6">
                                <?= __("Criado: ") ?>
                                <?= $this->Time->format(
                                    $estagiario->resposta->created,
                                    "d-MM-Y HH:mm",
                                ) ?>
                            </div>
                            <div class="col-6 text-end">
                                <?= __("Modificado: ") ?>
                                <?= $this->Time->format(
                                    $estagiario->resposta->modified,
                                    "d-MM-Y HH:mm",
                                ) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
