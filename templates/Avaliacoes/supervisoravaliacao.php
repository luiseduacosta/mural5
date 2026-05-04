<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
?>

<div class="avaliacaoes index container">

<h3><?= __('Avaliações') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-responsive table-hover">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Avaliação on-line') ?></th>
                <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Imprime avaliação') ?></th>
                <th><?= $this->Paginator->sort('estagiario->aluno->nome', 'Aluno') ?></th>
                <th><?= $this->Paginator->sort('estagiario->folhadeatividade->id', 'Folha de atividades') ?></th>
                <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('estagiario->professor->nome', 'Professor') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiario as $c_estagiario): ?>
                <tr>
                    <td><?= $c_estagiario->id ?></td>

                    <td>
                        <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                            <?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : $this->Html->link('Fazer avaliação on-line', ['controller' => 'avaliacoes', 'action' => 'add', '?' => ['estagiario_id' => $c_estagiario->id]], ['class' => 'btn btn-warning']) ?>
                        <?php else: ?>
                            <?= $c_estagiario->hasValue('avaliacao') ? $this->Html->link('Ver avaliação', ['controller' => 'Avaliacoes', 'action' => 'view', $c_estagiario->avaliacao->id], ['class' => 'btn btn-success']) : 'Sem avaliação on-line' ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= $this->Html->link('Imprime avaliação discente', ['controller' => 'estagiarios', 'action' => 'avaliacaodiscentepdf', $c_estagiario->id], ['class' => 'btn btn-outline-primary']) ?>
                    </td>

                    <td>
                        <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                            <?= $c_estagiario->hasValue('aluno') ? $this->Html->link($c_estagiario->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $c_estagiario->aluno->id]) : '' ?>
                        <?php else: ?>
                            <?= $c_estagiario->hasValue('aluno') ? $c_estagiario->aluno->nome : '' ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= $c_estagiario->hasValue('folhadeatividade') ? $this->Html->link('Ver folha de atividades on-line', ['controller' => 'folhadeatividades', 'action' => 'index', '?' => ['estagiario_id' => $c_estagiario->id]], ['class' => 'btn btn-success']) : $this->Html->link('Imprimir folha', ['controller' => 'estagiarios', 'action' => 'folhadeatividadespdf', $c_estagiario->id], ['class' => 'btn btn-outline-secondary']) ?>
                    </td>

                    <td><?= $c_estagiario->periodo ?></td>
                    <td><?= $c_estagiario->hasValue('professor') ? $c_estagiario->professor->nome : '' ?></td>
                    <td><?= $c_estagiario->nivel ?></td>
                    <td><?= $c_estagiario->ch ?></td>
                    <td><?= $c_estagiario->nota ?></td>

                    <?php if (($user_data['categoria'] === '1') || $user_data['supervisor_id']): ?>
                        <td class="actions">
                            <?php if ($c_estagiario->hasValue('avaliacao')): ?>
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->avaliacao->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->avaliacao->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->avaliacao->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $c_estagiario->avaliacao->id)]) ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>