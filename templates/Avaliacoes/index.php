<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiarios);
//die();
?>

<<<<<<< HEAD
<?php
$categoria = isset($this->getRequest()->getAttribute('identity')['categoria']) ? $this->getRequest()->getAttribute('identity')['categoria'] : null;
?>
=======
<?php echo $this->element('menu_mural') ?>
>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAvaliacoes"
        aria-controls="navbarTogglerAvaliacoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAvaliacoes">
        <?php if (isset($user) && $user->categoria == '1'): ?>
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
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $c_estagiario): ?>
                <tr>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= $this->Html->link($c_estagiario->estagiario->aluno->nome, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->estagiario_id]) ?></td>
                    <?php else: ?>
                        <td><?= $c_estagiario->estagiario->aluno->nome ?></td>
                    <?php endif; ?>

                    <?php if (isset($user) && ($user->categoria == '1' || $user->categoria == '4')): ?>
                        <td><?= $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->id], ['class' => 'btn btn-success']) ?></td>
                    <?php else: ?>
                        <td><?= $this->Html->link('Fazer avaliação', ['controller' => 'Avaliacoes', 'action' => 'add', $c_estagiario->id], ['class' => 'btn btn-warning']) ?></td>
                    <?php endif; ?>

                    <td><?= $c_estagiario->estagiario->periodo ?></td>
                    <td><?= $c_estagiario->estagiario->nivel ?></td>
                    <td><?= $c_estagiario->estagiario->instituicao->instituicao ?></td>
                    <td><?= $c_estagiario->estagiario->supervisor->nome ?></td>
                    <td><?= $c_estagiario->estagiario->ch ?></td>
                    <td><?= $c_estagiario->estagiario->nota ?></td>
                        
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <?php if (isset($c_estagiario->estagiario->id)): ?>
                            <td>
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->id], ['confirm' => __('Tem certeza que deseja excluir a avaliação # {0}?', $c_estagiario->id)]) ?>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagiario as $c_estagiario): ?>
                    <?php // pr($c_estagiario); ?>
                    <?php // die(); ?>
                    <tr>
                        <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
                            <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td><?= isset($c_estagiario->id) ? $c_estagiario->id : '' ?></td>
                        <?php endif; ?>

                        <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1 || $this->getRequest()->getAttribute('identity')['categoria'] == 4): ?>
                            <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : $this->Html->link('Fazer avaliação', ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $c_estagiario->id]], ['class' => 'btn btn-warning']) ?>
                            </td>
                        <?php else: ?>
                            <td><?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : 'Sem avaliação on-line' ?>
                            </td>
                        <?php endif; ?>

                        <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
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


                        <?php if (isset($c_estagiario->avaliacao->id)): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->avaliacao->id]) ?>
                                <?php if ($categoria <> 2): ?>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->avaliacao->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->avaliacao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $c_estagiario->avaliacao->id)]) ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>