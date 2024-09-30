<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Editar visita'), ['action' => 'edit', $visita->id], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Form->postLink(__('Excluir visita'), ['action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $visita->id), 'class' => 'btn btn-danger float-end']) ?>
            <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="container">
        <h3><?= h($visita->instituicaoestagios->instituicao) ?></h3>
        <table>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($visita->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Instituição') ?></th>
                <td><?= $visita->has('instituicaoestagio') ? $this->Html->link($visita->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $visita->instituicaoestagio->id]) : '' ?>
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