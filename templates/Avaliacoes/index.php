<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
// pr($estagiario);
// die();
?>
<div class="container">

    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 4 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 3): ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova Avaliação'), ['action' => 'add', $id], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                </ul>
            </div>
        </nav>

    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Avaliação') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->aluno->nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->instituicao->instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->supervisor->nome', 'Supervisor(a)') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                    <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                    <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagiario as $c_estagiario): ?>
                    <?php // pr($c_estagiario); ?>
                    <?php // die(); ?>
                    <tr>
                        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                            <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td><?= isset($c_estagiario->id) ? $c_estagiario->id : '' ?></td>
                        <?php endif; ?>

                        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1 || $this->getRequest()->getAttribute('identity')['categoria_id'] == 4): ?>
                            <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : $this->Html->link('Fazer avaliação', ['controller' => 'avaliacoes', 'action' => 'add', $c_estagiario->id], ['class' => 'btn btn-warning']) ?>
                            </td>
                        <?php else: ?>
                            <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : 'Sem avaliação on-line' ?>
                            </td>
                        <?php endif; ?>

                        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                            <td><?= $c_estagiario->hasValue('aluno') ? $this->Html->link($c_estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $c_estagiario->aluno->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td><?= $c_estagiario->hasValue('aluno') ? $c_estagiario->aluno->nome : '' ?></td>
                        <?php endif; ?>

                        <td><?= $c_estagiario->periodo ?></td>
                        <td><?= $c_estagiario->nivel ?></td>
                        <td><?= $c_estagiario->hasValue('instituicao') ? $c_estagiario->instituicao->instituicao : '' ?>
                        </td>
                        <td><?= $c_estagiario->hasValue('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                        <td><?= $c_estagiario->ch ?></td>
                        <td><?= $c_estagiario->nota ?></td>

                        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                            <?php if (isset($c_estagiario->avaliacao->id)): ?>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->avaliacao->id]) ?>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->avaliacao->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->avaliacao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $c_estagiario->avaliacao->id)]) ?>
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>