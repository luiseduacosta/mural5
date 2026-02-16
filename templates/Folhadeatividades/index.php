<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade[]|\Cake\Collection\CollectionInterface $folhadeatividades
 */
// pr($estagiario->supervisor);
// pr($folhadeatividades);
// die();

if (isset($estagiario->supervisor->nome)) {
    $supervisora = $estagiario->supervisor->nome;
} else {
    $supervisora = '_______________';
}

if (isset($estagiario->supervisor->cress)) {
    $cress = $estagiario->supervisor->cress;
} else {
    $cress = '_______________';
}

if (isset($estagiario->professor->nome)) {
    $professora = $estagiario->professor->nome;
} else {
    $professora = '_______________';
}
?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAtividades"
            aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerAtividades">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if ($user->isAdmin() || $user->isStudent()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-warning float-end', 'style' => 'max-width:2000px; word-wrap:break-word; font-size:14px']) ?>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Imprime atividades'), ['action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:200px; word-wrap:break-word; font-size:14px']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Imprime folha de atividades'), ['controller' => 'estagiarios', 'action' => 'folhadeatividadespdf', $estagiario->id], ['class' => 'btn btn-primary float-end', 'style' => 'max-width:200px; word-wrap:break-word; font-size:14px']) ?>
                </li>

            </ul>
        </div>
    </nav>

    <h3 class="text-center"><?= __('Folha de atividades da(o) estagiária(o) ' . $estagiario->aluno->nome) ?></h3>

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
                <td><?= $estagiario->instituicao->instituicao ?></td>
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
                    <th><?= $this->Paginator->sort('dia') ?></th>
                    <th><?= $this->Paginator->sort('inicio') ?></th>
                    <th><?= $this->Paginator->sort('final') ?></th>
                    <th><?= $this->Paginator->sort('horario', 'Horas') ?></th>
                    <th><?= $this->Paginator->sort('atividade') ?></th>
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $seconds = NULL ?>
                <?php foreach ($folhadeatividades as $folhadeatividade): ?>
                    <tr>
                        <td><?= $folhadeatividade->id ?></td>
                        <td><?= h($folhadeatividade->dia) ?></td>
                        <td><?= h($folhadeatividade->inicio) ?></td>
                        <td><?= h($folhadeatividade->final) ?></td>
                        <td><?= h($folhadeatividade->horario) ?></td>
                        <td><?= h($folhadeatividade->atividade) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $folhadeatividade->id]) ?>
                            <?php if ($user->isAdmin() || $user->isStudent()): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $folhadeatividade->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $folhadeatividade->id)]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                    list($hour, $minute, $second) = array_pad(explode(':', $folhadeatividade->horario), 3, null);
                    $seconds += (int) $hour * 3600;
                    $seconds += (int) $minute * 60;
                    $seconds += (int) $second;
                    // pr($seconds);
                    ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4">Total de horas</td>
                    <td>
                        <?php
                        $hours = floor($seconds / 3600);
                        $seconds -= $hours * 3600;
                        $minutes = floor($seconds / 60);
                        $seconds -= $minutes * 60;
                        echo $hours . ":" . $minutes . ":" . $seconds;
                        ?>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
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