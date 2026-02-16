<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
?>

<?= $this->element('templates') ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerComplemento"
            aria-controls="navbarTogglerComplemento" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerComplemento">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar registro'), ['action' => 'edit', $complemento->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir registro'), ['action' => 'delete', $complemento->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $complemento->id), 'class' => 'btn btn-danger me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar registros'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
 
        <div class="table-responsive">
            <h3><?= h($complemento->periodo_especial) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Periodo Especial') ?></th>
                    <td><?= h($complemento->periodo_especial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($complemento->id) ?></td>
                </tr>
            </table>

            <div class="related">
                <h4><?= __('Estagiários') ?></h4>
                <?php if (!empty($complemento->estagiarios)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-responsive">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Registro') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Nivel') ?></th>
                                <th><?= __('Tc') ?></th>
                                <th><?= __('Tc Solicitacao') ?></th>
                                <th><?= __('Instituicao de estagio') ?></th>
                                <th><?= __('Supervisor') ?></th>
                                <th><?= __('Professor') ?></th>
                                <th><?= __('Periodo') ?></th>
                                <th><?= __('Turma') ?></th>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('Ch') ?></th>
                                <th><?= __('Observacoes') ?></th>
                                <th><?= __('Complemento') ?></th>
                                <th><?= __('Aluno') ?></th>
                                <th><?= __('Ajuste2020') ?></th>
                                <th class="actions"><?= __('Açoes') ?></th>
                            </tr>
                            <?php foreach ($complemento->estagiarios as $estagiarios) : ?>
                                <tr>
                                    <td><?= h($estagiarios->id) ?></td>
                                    <td><?= h($estagiarios->registro) ?></td>
                                    <td><?= h($estagiarios->turno) ?></td>
                                    <td><?= h($estagiarios->nivel) ?></td>
                                    <td><?= h($estagiarios->tc) ?></td>
                                    <td><?= h($estagiarios->tc_solicitacao) ?></td>
                                    <td><?= h($estagiarios->instituicao_id) ?></td>
                                    <td><?= h($estagiarios->supervisor_id) ?></td>
                                    <td><?= h($estagiarios->professor_id) ?></td>
                                    <td><?= h($estagiarios->periodo) ?></td>
                                    <td><?= h($estagiarios->turmaestagio_id) ?></td>
                                    <td><?= h($estagiarios->nota) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                    <td><?= h($estagiarios->observacoes) ?></td>
                                    <td><?= h($estagiarios->complemento_id) ?></td>
                                    <td><?= h($estagiarios->aluno_id) ?></td>
                                    <td><?= h($estagiarios->ajuste2020) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id], ['class' => 'btn btn-primary me-1']) ?>
                                        <?php if ($user->isAdmin()): ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id], ['class' => 'btn btn-primary me-1']) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id), 'class' => 'btn btn-danger me-1']) ?>
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