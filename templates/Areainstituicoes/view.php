<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('Editar área instituição'), ['action' => 'edit', $areainstituicao->id], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Form->postLink(__('Excluir área instituição'), ['action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $areainstituicao->id), 'class' => 'btn btn-danger float-end']) ?>
            <?= $this->Html->link(__('Listar área instituições'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            <?= $this->Html->link(__('Nova área instituição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areainstituicoes view content">
            <h3><?= h($areainstituicao->area) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= h($areainstituicao->area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($areainstituicao->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
