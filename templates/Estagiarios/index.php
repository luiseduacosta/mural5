<?php
$usuario = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
// pr($estagiarios);
// pr($periodo);
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'index?periodo=']); ?>";
        // alert(url);
        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + periodo;
        })

    })
</script>

<?php
// die();
?>
<?= $this->element('templates') ?>
<div class='row'>
    <?php if ($usuario->categoria == 1): ?>
        <?= $this->Form->create($estagiarios); ?>
        <div class="form-group row">
            <label class='col-sm-1 col-form-label'>Período</label>
            <div class='col-sm-2'>
                <?= $this->Form->control('periodo', ['id' => 'EstagiarioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    <?php else: ?>
        <h1 style="text-align: center;">Estagiários da ESS/UFRJ. Período: <?= $periodo ?></h1>
    <?php endif; ?>
</div>

<div class="estagiarios index content">
    <?php if ($usuario->categoria == 1): ?>
        <?= $this->Html->link(__('Novo estagiário'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <?php endif; ?>
    <h3><?= __('Estagiarios') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Estagiarios.id', 'Id') ?></th>
                    <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('ajuste2020', 'Ajuste 2020') ?></th>
                    <th><?= $this->Paginator->sort('turno') ?></th>
                    <th><?= $this->Paginator->sort('nivel') ?></th>
                    <th><?= $this->Paginator->sort('tc') ?></th>
                    <th><?= $this->Paginator->sort('tc_solicitacao') ?></th>
                    <th><?= $this->Paginator->sort('Instituicaoestagios.instituicao', 'Instituicao') ?></th>
                    <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                    <th><?= $this->Paginator->sort('Docentes.nome', 'Professor/a') ?></th>
                    <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                    <th><?= $this->Paginator->sort('Areaestagio.area', 'Área') ?></th>
                    <th><?= $this->Paginator->sort('nota') ?></th>
                    <th><?= $this->Paginator->sort('ch', 'CH') ?></th>
                    <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    <?php if ($usuario->categoria == 1): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estagiarios as $estagiario): ?>
                    <tr>
                        <?php // pr($estagiario); ?>
                        <td><?= $estagiario->id ?></td>
                        <td><?= $estagiario->has('estudante') ? $this->Html->link($estagiario->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $estagiario->alunonovo_id]) : '' ?>
                        </td>
                        <td><?= $estagiario->registro ?></td>
                        <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                        <td><?= h($estagiario->turno) ?></td>
                        <td><?= h($estagiario->nivel) ?></td>
                        <td><?= $estagiario->tc ?></td>
                        <td><?= date('d-m-Y', strtotime(h($estagiario->tc_solicitacao))) ?></td>
                        <?php if (!empty($estagiario->instituicaoestagio->instituicao)): ?>
                            <td><?= $estagiario->has('instituicaoestagio') ? $this->Html->link($estagiario->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiario->instituicaoestagio->id]) : '' ?>
                            </td>
                        <?php endif; ?>
                        <?php if (!empty($estagiario->supervisor->nome)): ?>
                            <td><?= $estagiario->has('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                        <?php if (!empty($estagiario->docente->nome)): ?>
                            <td><?= $estagiario->has('docente') ? $this->Html->link($estagiario->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $estagiario->docente->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                        <td><?= h($estagiario->periodo) ?></td>
                        <?php if (!empty($estagiario->areaestagio->area)): ?>
                            <td><?= $estagiario->has('areaestagio') ? $this->Html->link($estagiario->areaestagio->area, ['controller' => 'Areaestagios', 'action' => 'view', $estagiario->id_area]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                        <td><?= $this->Number->format($estagiario->nota, ['precision' => 2]) ?></td>
                        <td><?= $this->Number->format($estagiario->ch) ?></td>
                        <td><?= h($estagiario->observacoes) ?></td>
                        <?php if ($usuario->categoria == 1): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id)]) ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <?= $this->element('templates') ?>
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
        </div>
    </div>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
    </p>
</div>