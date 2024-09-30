<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
?>
<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?= $this->Html->link(__('Edita atividade'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Form->postLink(__('Excluir atividade'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger float-end']) ?>
                <?= $this->Html->link(__('Listar atividades'), ['action' => 'index', $folhadeatividade->estagiario_id], ['class' => 'btn btn-primary float-end']) ?>
                <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', $folhadeatividade->estagiario_id], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="table-responsive">
            <h3><?= h($folhadeatividade->atividade) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Atividade') ?></th>
                    <td><?= h($folhadeatividade->atividade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $folhadeatividade->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Estagiário') ?></th>
                    <td><?= $folhadeatividade->estagiario_id ?></td>
                </tr>
                <tr>
                    <th><?= __('Día') ?></th>
                    <td><?= h($folhadeatividade->dia) ?></td>
                </tr>
                <tr>
                    <th><?= __('Início') ?></th>
                    <td><?= h($folhadeatividade->inicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final') ?></th>
                    <td><?= h($folhadeatividade->final) ?></td>
                </tr>
                <tr>
                    <th><?= __('Horário') ?></th>
                    <td><?= h($folhadeatividade->horario) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>