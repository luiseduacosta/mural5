<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
// pr($estagiario);
// die();
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

                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 2): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'estagiarios', 'action' => 'termodecompromisso', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:115px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Declaração de estágio'), ['action' => 'declaracaodeestagiopdf', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Preencher Atividades'), ['controller' => 'folhadeatividades', 'action' => 'view', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprimir Atividades'), ['controller' => 'folhadeatividades', 'action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Imprimir Avaliação'), ['action' => 'avaliacaodiscentepdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 4): ?>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Preencher Avaliação'), ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:100px; word-wrap:break-word; font-size:14px']) ?>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= h($estagiario->estudante->nome) ?></h3>
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
                <th><?= __('Estudante') ?></th>
                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                    <td><?= (isset($estagiario->estudante)) ? $this->Html->link($estagiario->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $estagiario->estudante->id]) : '' ?>
                    </td>
                <?php else: ?>
                    <td><?= $estagiario->hasValue('estudante') ? $estagiario->estudante->nome : '' ?></td>
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
</div>