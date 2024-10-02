<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade[]|\Cake\Collection\CollectionInterface $folhadeatividades
 */
// pr($id);

$supervisora = isset($estagiario->supervisor->nome);
if ($supervisora) {
    $supervisora = $estagiario->supervisor->nome;
} else {
    $supervisora = '_______________';
}

$cress = isset($estagiario->supervisor->cress);
if ($cress) {
    $cress = $estagiario->supervisor->cress;
} else {
    $cress = '_______________';
}

$professora = isset($estagiario->docente->nome);
if ($professora) {
    $professora = $estagiario->docente->nome;
} else {
    $professora = '_______________';
}
?>

<div class="container">
    <?= $this->Html->link(__('Cadastra nova atividade'), ['action' => 'add/' . $id], ['class' => 'btn btn-primary float-end']) ?>
    <?= $this->Html->link(__('Imprime folha de atividades'), ['action' => 'folhadeatividadespdf/' . $id], ['class' => 'btn btn-primary float-end']) ?>
    <h3 class="text-center"><?= __('Folha de atividades da(o) estagiária(o) ' . $estagiario->estudante->nome) ?></h3>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th>Período</th>
                <th>Nível</th>
                <th>Instituição</th>
                <th>Supervisor</th>
                <th>Professor(a)</th>
            </tr>
            <tr>
                <td><?= $estagiario->periodo ?></td>
                <td><?= $estagiario->nivel ?></td>
                <td><?= $estagiario->instituicaoestagio->instituicao ?></td>
                <td><?= $supervisora ?></td>
                <td><?= $professora ?></td>
            </tr>
        </table>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('estagiario_id') ?></th>
                    <th><?= $this->Paginator->sort('dia') ?></th>
                    <th><?= $this->Paginator->sort('inicio') ?></th>
                    <th><?= $this->Paginator->sort('final') ?></th>
                    <th><?= $this->Paginator->sort('horario', 'Horas') ?></th>
                    <th><?= $this->Paginator->sort('atividade') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $seconds = NULL ?>
                <?php foreach ($folhadeatividades as $folhadeatividade): ?>
                    <tr>
                        <td><?= $folhadeatividade->id ?></td>
                        <td><?= $folhadeatividade->estagiario_id ?></td>
                        <td><?= h($folhadeatividade->dia) ?></td>
                        <td><?= h($folhadeatividade->inicio) ?></td>
                        <td><?= h($folhadeatividade->final) ?></td>
                        <td><?= h($folhadeatividade->horario) ?></td>
                        <td><?= h($folhadeatividade->atividade) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $folhadeatividade->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $folhadeatividade->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $folhadeatividade->id)]) ?>
                        </td>
                    </tr>
                    <?php
                    list($hour, $minute, $second) = array_pad(explode(':', $folhadeatividade->horario), 3, null);
                    $seconds += $hour * 3600;
                    $seconds += $minute * 60;
                    $seconds += $second;
                    // pr($seconds);
                    ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5">Total de horas</td>
                    <td>
                        <?php
                        $hours = floor($seconds / 3600);
                        $seconds -= $hours * 3600;
                        $minutes = floor($seconds / 60);
                        $seconds -= $minutes * 60;
                        echo $hours . ":" . $minutes . ":" . $seconds;
                        ?>
                    </td>
    </div>
    <td></td>
    </tr>
    </tbody>
    </table>
</div>

<?= $this->element('templates'); ?>
<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->element('paginator') ?>
        </ul>
    </div>
</div>
<?= $this->element('paginator_count') ?>
</div>