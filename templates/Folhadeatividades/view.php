<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
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
                <li class="nav-item">
                    <?= $this->Html->link(__('Edita atividade'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir atividade'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar atividades'), ['action' => 'index', '?' => ['estagiario_id' => $folhadeatividade->estagiario_id]], ['class' => 'btn btn-primary float-end']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', '?' => ['estagiario_id' => $folhadeatividade->estagiario_id]], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

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