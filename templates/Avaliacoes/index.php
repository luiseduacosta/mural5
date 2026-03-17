<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
$categoria = $this->getRequest()->getAttribute('identity')['categoria'];
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAvaliacoes"
        aria-controls="navbarTogglerAvaliacoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAvaliacoes">
        <?php if ($categoria == 1 || $categoria == 4): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova Avaliação'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>                
        <?php endif; ?>
    </ul>
</nav>

<h3><?= __('Avaliações') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-responsive table-hover">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('estagiario.aluno.nome', 'Aluno') ?></th>
                <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Avaliação') ?></th>
                <th><?= $this->Paginator->sort('estagiario.periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('estagiario.nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('estagiario.instituicao.instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('estagiario.supervisor.nome', 'Supervisor(a)') ?></th>
                <th><?= $this->Paginator->sort('estagiario.ch', 'Carga horária') ?></th>
                <th><?= $this->Paginator->sort('estagiario.nota', 'Nota') ?></th>
                <?php if (isset($categoria) && ($categoria == 1 || $categoria == 4)): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $c_estagiario): ?>
                <tr>
                    <?php if ($categoria == 1 || $categoria == 4): ?>
                        <td><?= $this->Html->link($c_estagiario->aluno->nome, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) ?></td>
                    <?php else: ?>
                        <td><?= $c_estagiario->aluno->nome ?></td>
                    <?php endif; ?>

                    <?php if (isset($categoria) && ($categoria == 1 || $categoria == 4)): ?>
                        <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : $this->Html->link('Fazer avaliação', ['controller' => 'Avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $c_estagiario->id]], ['class' => 'btn btn-warning']) ?></td>
                    <?php else: ?>
                        <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : 'Sem avaliação on-line' ?></td>
                    <?php endif; ?>

                    <td><?= $c_estagiario->periodo ?></td>
                    <td><?= $c_estagiario->nivel ?></td>
                    <td><?= $c_estagiario->hasValue('instituicao') ? $c_estagiario->instituicao->instituicao : '' ?></td>
                    <td><?= $c_estagiario->hasValue('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                    <td><?= $c_estagiario->ch ?></td>
                    <td><?= $c_estagiario->nota ?></td>
                        
                    <?php if ($categoria == 1 || $categoria == 4): ?>
                        <td class="actions">
                            <?php if ($c_estagiario->hasValue('avaliacao')): ?>
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->avaliacao->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->avaliacao->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->avaliacao->id], ['confirm' => __('Tem certeza que deseja excluir a avaliação # {0}?', $c_estagiario->avaliacao->id)]) ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>