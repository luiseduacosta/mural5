<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>

<div class='container'>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Inserir Estagiario'), ['action' => 'add'], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item active">
                        <?= $this->Form->postLink(__('Excluir Estagiario'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>

                <!-- Professor pode lançar notas -->
                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 3): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Estagiario'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:120px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>

                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 2): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'estagiarios', 'action' => 'termodecompromisso', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:180px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Declaração de estágio'), ['action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:180px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Preenche Atividades'), ['controller' => 'folhadeatividades', 'action' => 'index', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:180px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprime Atividades'), ['controller' => 'folhadeatividades', 'action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:150px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprime folha de atividades'), ['controller' => 'estagiarios', 'action' => 'folhadeatividadespdf', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:200px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprime Avaliação'), ['action' => 'avaliacaodiscentepdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:150px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 4): ?>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Preencher Avaliação'), ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:150px; word-wrap:break-word; font-size:14px']) ?>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" id="estagiario-tab" href="#estagiario"
                data-target="#estagiario" role="tab" aria-controls="estagiario" aria-selected="true">Estagiario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="folhadeatividade-tab" href="#folhadeatividade"
                data-target="#folhadeatividade" role="tab" aria-controls="folhadeatividade" aria-selected="false">Folha
                de
                atividades</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="avaliacao-tab" href="#avaliacao" data-target="#avaliacao"
                role="tab" aria-controls="avaliacao" aria-selected="true">Avaliação</a>
        </li>
    </ul>

    <div class="tab-content" id="meuTabContent">

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
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
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
                    <td><?= h($estagiario->turno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nível') ?></th>
                    <td><?= h($estagiario->nivel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                        <td><?= $estagiario->hasValue('instituicao') ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('instituicao') ? $estagiario->instituicao->instituicao : '' ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Supervisor(a)') ?></th>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                        <td><?= $estagiario->hasValue('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $estagiario->hasValue('supervisor') ? $estagiario->supervisor->nome : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Professor') ?></th>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
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
                    <th><?= __('Turma de estágio') ?></th>
                    <td><?= $estagiario->hasValue('turmaestagio') ? $this->Html->link($estagiario->turmaestagio->area, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio->id]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('TC') ?></th>
                    <td><?= $this->Number->format($estagiario->tc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data TC') ?></th>
                    <td><?= $estagiario->tc_solicitacao ? $estagiario->tc_solicitacao : '' ?></td>
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

        <div id="folhadeatividade" class="tab-pane fade show active" role="tabpanel" aria-labelledby="folhadeatividade-tab">
            <?php if ($estagiario->hasValue('folhadeatividades')): ?>
                <h3>Atividades</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Início</th>
                                <th>Final</th>
                                <th>Horário</th>
                                <th>Atividade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $seconds = 0 ?>
                            <?php foreach ($estagiario->folhadeatividades as $atividade): ?>
                                <tr>
                                    <td><?= $atividade->dia ?></td>
                                    <td><?= $atividade->inicio ?></td>
                                    <td><?= $atividade->final ?></td>
                                    <td><?= $atividade->horario ?></td>
                                    <td><?= $atividade->atividade ?></td>
                                    <?php
                                    list($hour, $minute, $second) = array_pad(explode(':', $atividade->horario), 3, null);
                                    $seconds += (int) $hour * 3600;
                                    $seconds += (int) $minute * 60;
                                    $seconds += (int) $second;
                                    // pr($seconds);
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <?php
                                    $hours = floor($seconds / 3600);
                                    $seconds -= $hours * 3600;
                                    $minutes = floor($seconds / 60);
                                    $seconds -= $minutes * 60;
                                    echo $hours . ":" . $minutes . ":" . $seconds;
                                    ?>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div id="avaliacao" class="tab-pane fade show active" role="tabpanel" aria-labelledby="avaliacao-tab">
            <?php if ($estagiario->hasValue('avaliacao')): ?>
                <h3>Avaliações</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td><?= $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $estagiario->avaliacao->id]) ?>
                            </td>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>