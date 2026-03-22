<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
$categoria = $this->getRequest()->getAttribute('identity')['categoria'];
?>

<?php echo $this->element('menu_mural') ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAluno"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerAluno">
            <ul class="navbar-nav ms-auto mt-lg-0">

                <?php if ($categoria == 2): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Alunos'), ['controller' => 'Alunos', 'action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'certificadoperiodo', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>

                <?php if ($categoria == 1): ?>

                    <li class="nav-item">
                        <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'novotermocompromisso', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Adicionar estágio'), ['controller' => 'Estagiarios', 'action' => 'add', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo Aluno'), ['controller' => 'Alunos', 'action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Aluno'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir Aluno'), ['controller' => 'Alunos', 'action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id), 'class' => 'btn btn-danger me-1']) ?>
                    </li>
                </ul>
            <?php endif ?>
            <?php if ($categoria == 2): ?>
                <?php if ($user->aluno_id == $aluno->id): ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <?= $this->Html->link(__('Editar Aluno'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'certificadoperiodo', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'novotermocompromisso', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                    </ul>
                <?php endif; ?>
            <?php endif ?>
    </div>
</nav>

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" id="aluno-tab" href="#aluno" data-target="#aluno" role="tab"
                aria-controls="aluno" aria-selected="true">Dados do
                aluno</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="inscricoes-tab" href="#inscricoes" data-target="#inscricoes"
                role="tab" aria-controls="inscricoes" aria-selected="false">Inscrições para estágio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="estagios-tab" href="#estagios" data-target="#estagios"
                role="tab" aria-controls="estagios" aria-selected="true">Estágios cursados</a>
        </li>
    </ul>

    <div class="row">

        <div class="tab-content">
            <div id="aluno" class="tab-pane container active show">
                <h3><?= h($aluno->nome) ?></h3>
                <table class="table table-hover table-responsive table-striped">
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
                        <th><?= __('Nome social') ?></th>
                        <td><?= h($aluno->nomesocial) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Ingresso') ?></th>
                        <td><?= h($aluno->ingresso) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Turno') ?></th>
                        <td><?= h($aluno->turno) ?></td>
                    </tr>
                    <?php if ($categoria == 1 || ($categoria == 2 && $aluno->id == $user->aluno_id)): ?>
                        <tr>
                            <th><?= __('Data de nascimento') ?></th>
                            <td><?= $aluno->nascimento ? $aluno->nascimento->i18nFormat('dd-MM-yyyy') : '' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('CPF') ?></th>
                            <td><?= h($aluno->cpf) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('RG') ?></th>
                            <td><?= h($aluno->identidade) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Orgão') ?></th>
                            <td><?= h($aluno->orgao) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('E-mail') ?></th>
                            <td><?= h($aluno->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('DDD') ?></th>
                            <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Telefone') ?></th>
                            <td><?= h($aluno->telefone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('DDD') ?></th>
                            <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Celular') ?></th>
                            <td><?= h($aluno->celular) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('CEP') ?></th>
                            <td><?= h($aluno->cep) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Endereço') ?></th>
                            <td><?= h($aluno->endereco) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Município') ?></th>
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
                    <?php endif ?>
                </table>
            </div>
        </div>

        <div id="inscricoes" class="tab-pane" role="tabpanel" aria-labelledby="inscricoes-tab">
            <h4><?= __('Inscrições para seleção de estágio') ?></h4>
            <?php if (!empty($aluno->inscricoes)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Mural de estágio') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Período') ?></th>
                            <?php if ($categoria == 1): ?>
                                <th><?= __('Timestamp') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php elseif ($categoria == 2): ?>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($aluno->inscricoes as $inscricoes): ?>
                            <tr>
                                <td><?= h($inscricoes->id) ?></td>
                                <td><?= h($inscricoes->registro) ?></td>
                                <?php if ($categoria == 1): ?>
                                    <td><?= $inscricoes->hasValue('muralestagio') ? $this->Html->link($inscricoes->muralestagio->instituicao, ['controller' => 'muralestagios', 'action' => 'view', $inscricoes->muralestagio->id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $inscricoes->hasValue('muralestagio') ? $inscricoes->muralestagio->instituicao : '' ?>
                                    </td>
                                <?php endif; ?>
                                <td><?= date('d-m-Y', strtotime(h($inscricoes->data))) ?></td>
                                <td><?= h($inscricoes->periodo) ?></td>
                                <?php if ($categoria == 1): ?>
                                    <td><?= h($inscricoes->timestamp) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricoes->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $inscricoes->id)]) ?>
                                    </td>
                                <?php elseif ($categoria == 2): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscricoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $inscricoes->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="estagios" class="tab-pane container fade">
                <h4><?= __('Estágios cursados') ?></h4>
                <?php if (!empty($aluno->estagiarios)): ?>
                    <table class="table table-hover table-responsive table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Aluno') ?></th>
                                <th><?= __('Estagiario') ?></th>
                                <th><?= __('Ajuste 2020') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Nível') ?></th>
                                <th><?= __('Período') ?></th>
                                <th><?= __('Tc') ?></th>
                                <th><?= __('Tc Solicitação') ?></th>
                                <th><?= __('Instituição de estágio') ?></th>
                                <th><?= __('Supervisor') ?></th>
                                <th><?= __('Docente') ?></th>
                                <th><?= __('Turma de estágio') ?></th>
                                <?php if ($categoria == 1): ?>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th><?= __('Observações') ?></th>
                                    <th><?= __('Ações') ?></th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <?php foreach ($aluno->estagiarios as $estagiarios): ?>
                            <tr>
                                <?php // pr($estagiarios); ?>
                                <td><?= h($estagiarios->id) ?></td>
                                <?php if ($categoria == 1): ?>
                                    <td><?= $estagiarios->hasValue('aluno') ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                                <?php endif; ?>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->periodo) ?></td>

                                <?php if ($categoria == 1): ?>
                                    <td><?= $estagiarios->hasValue('instituicao') ? $this->Html->link($estagiarios->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiarios->instituicao_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('instituicao') ? $estagiarios->instituicao->instituicao : '' ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($categoria == 1): ?>
                                    <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                <?php endif; ?>

                                <?php if ($categoria == 1): ?>
                                    <td><?= $estagiarios->hasValue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor->id]) : 'Sem dados' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('professor') ? $estagiarios->professor->nome : 'Sem informação' ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($estagiarios->nota): ?>
                                    <td><?= $this->Number->format($estagiarios->nota, ['places' => 2]) ?></td>
                                <?php else: ?>
                                    <td>Sem nota</td>
                                <?php endif; ?>

                                <td><?= h($estagiarios->ch) ?></td>
                                <td><?= h($estagiarios->observacoes) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                    <?php if ($categoria == 1): ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id)]) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>