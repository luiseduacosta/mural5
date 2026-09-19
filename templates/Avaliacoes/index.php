<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
declare(strict_types=1);
?>
<?= $this->element('templates') ?>

<div class="container">

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h3><?= __('Avaliações') ?></h3>
        </div>
        <div>
            <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                <?= $this->Html->link(__('Nova Avaliação'), ['action' => 'add'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>                
            <?php endif; ?>
        </div>
    </div>

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
                <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $c_estagiario): ?>
                <tr>
                    <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                        <td><?= $this->Html->link($c_estagiario->aluno->nome ?? 'Sem nome', ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) ?></td>
                    <?php else: ?>
                        <td><?= $c_estagiario->aluno->nome ?></td>
                    <?php endif; ?>

                    <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
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
                        
                    <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
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
    <div class="d-flex justify-content-center mt-4">
        <?= $this->element('paginator') ?>
    </div>
    <?= $this->element('paginator_count') ?>
</div>