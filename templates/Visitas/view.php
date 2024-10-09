<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
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
                    <?= $this->Html->link(__('Editar visita'), ['action' => 'edit', $visita->id], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Form->postLink(__('Excluir visita'), ['action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $visita->id), 'class' => 'btn btn-danger float-end']) ?>
                    <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    <?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= h($visita->instituicoes->instituicao) ?></h3>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($visita->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Instituição') ?></th>
                <td><?= $visita->hasValue('instituicao') ? $this->Html->link($visita->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Motivo') ?></th>
                <td><?= h($visita->motivo) ?></td>
            </tr>
            <tr>
                <th><?= __('Responsável') ?></th>
                <td><?= h($visita->responsavel) ?></td>
            </tr>
            <tr>
                <th><?= __('Avaliação') ?></th>
                <td><?= h($visita->avaliacao) ?></td>
            </tr>
            <tr>
                <th><?= __('Data') ?></th>
                <td><?= h($visita->data) ?></td>
            </tr>
        </table>
        <div class="text">
            <strong><?= __('Descrição') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($visita->descricao)); ?>
            </blockquote>
        </div>
    </div>
</div>