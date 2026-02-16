<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Alunoestagiario $alunoestagiario
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
<?php if($user->isAdmin()): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo aluno(a) estagiario(a)'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                </li>

                <li class="nav-item">
                    <?= $this->Html->link(__('Editar aluno(a) estagiario(a)'), ['action' => 'edit', $alunoestagiario->id], ['class' => 'btn btn-primary']) ?>
                </li>
<?php endif; ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar aluno(a)s estagiario(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
                </li>
                
<?php if($user->isAdmin()): ?>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir aluno(a) estagiario(a)'), ['action' => 'delete', $alunoestagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $alunoestagiario->id), 'class' => 'btn btn-danger']) ?>
                </li>
<?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">

    <h3><?= h($alunoestagiario->nome) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $alunoestagiario->id ?></td>
            </tr>
            <tr>
                <th><?= __('Registro') ?></th>
                <td><?= $alunoestagiario->registro ?></td>
            </tr>
            <tr>
                <th><?= __('Nome') ?></th>
                <td><?= h($alunoestagiario->nome) ?></td>
            </tr>
            <tr>
                <th><?= __('Nascimento') ?></th>
                <td><?= date('d-m-Y', strtotime(h($alunoestagiario->nascimento))) ?></td>
            </tr>
            <tr>
                <th><?= __('CPF') ?></th>
                <td><?= h($alunoestagiario->cpf) ?></td>
            </tr>
            <tr>
                <th><?= __('Identidade') ?></th>
                <td><?= h($alunoestagiario->identidade) ?></td>
            </tr>
            <tr>
                <th><?= __('Orgão') ?></th>
                <td><?= h($alunoestagiario->orgao) ?></td>
            </tr>
            <tr>
                <th><?= __('E-mail') ?></th>
                <td><?= h($alunoestagiario->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Código Telefone') ?></th>
                <td><?= $this->Number->format($alunoestagiario->codigo_telefone) ?></td>
            </tr>
            <tr>
                <th><?= __('Telefone') ?></th>
                <td><?= h($alunoestagiario->telefone) ?></td>
            </tr>
            <tr>
                <th><?= __('Código Celular') ?></th>
                <td><?= $this->Number->format($alunoestagiario->codigo_celular) ?></td>
            </tr>
            <tr>
                <th><?= __('Celular') ?></th>
                <td><?= h($alunoestagiario->celular) ?></td>
            </tr>
            <tr>
                <th><?= __('CEP') ?></th>
                <td><?= h($alunoestagiario->cep) ?></td>
            </tr>
            <tr>
                <th><?= __('EndereÇo') ?></th>
                <td><?= h($alunoestagiario->endereco) ?></td>
            </tr>
            <tr>
                <th><?= __('Município') ?></th>
                <td><?= h($alunoestagiario->municipio) ?></td>
            </tr>
            <tr>
                <th><?= __('Bairro') ?></th>
                <td><?= h($alunoestagiario->bairro) ?></td>
            </tr>
            <tr>
                <th><?= __('Observações') ?></th>
                <td><?= h($alunoestagiario->observacoes) ?></td>
            </tr>
        </table>

        <div class="container">
            <h4><?= __('Estágios cursados') ?></h4>
            <?php if (!empty($alunoestagiario->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estagiário(a)') ?></th>
                            <th><?= __('Ajuste 2020') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Tc') ?></th>
                            <th><?= __('Tc Solicitação') ?></th>
                            <th><?= __('Instituição de estagio') ?></th>
                            <th><?= __('Supervisor(a)') ?></th>
                            <th><?= __('Professor(a)') ?></th>
                            <th><?= __('Àrea de estágio') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                            <th><?= __('Observações') ?></th>
                            <?php if($user->isAdmin()): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($alunoestagiario->estagiarios as $estagiarios): ?>
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
                                <td><?= $estagiarios->hasValue('instituicao') ? $this->Html->link($estagiarios->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiarios->instituicao->id]) : '' ?>
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
                                <?php if($user->isAdmin()): ?>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id)]) ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>