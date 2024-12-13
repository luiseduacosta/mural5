<?php
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

<?php $usuario = $this->getRequest()->getAttribute('identity'); ?>

<?= $this->element('templates') ?>

<div class='container'>

    <?php if (isset($usuario) && $usuario['categoria_id'] == '1'): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                    aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo(a) estagiário(a)'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <?php if (isset($usuario) && $usuario['categoria_id'] == '1'): ?>

        <h3><?= __('Estagiario(a)s') ?></h3>

        <?= $this->Form->create($estagiarios); ?>
        <div class="form-group row">
            <label class='col-sm-1 col-form-label'>Período</label>
            <div class='col-sm-2'>
                <?= $this->Form->control('periodo', ['id' => 'EstagiarioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    <?php else: ?>
        <h3 style="text-align: center;">Estagiários da ESS/UFRJ. Período: <?= $periodo ?></h3>
    <?php endif; ?>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('Estagiarios.id', 'Id') ?></th>
                        <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                        <th><?= $this->Paginator->sort('registro') ?></th>
                        <th><?= $this->Paginator->sort('ajuste2020', 'Ajuste 2020') ?></th>
                        <th><?= $this->Paginator->sort('turno') ?></th>
                        <th><?= $this->Paginator->sort('nivel') ?></th>
                        <th><?= $this->Paginator->sort('tc') ?></th>
                        <th><?= $this->Paginator->sort('tc_solicitacao') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituicoes') ?></th>
                        <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                        <th><?= $this->Paginator->sort('Professores.nome', 'Professor/a') ?></th>
                        <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                        <th><?= $this->Paginator->sort('Turmaaestagio.area', 'Turma') ?></th>
                        <th><?= $this->Paginator->sort('Complemento.id', 'Tipo') ?></th>
                        <th><?= $this->Paginator->sort('nota') ?></th>
                        <th><?= $this->Paginator->sort('ch', 'Carga horária') ?></th>
                        <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                        <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estagiarios as $estagiario): ?>
                        <tr>
                            <?php // pr($estagiario); ?>
                            <td><?= $estagiario->id ?></td>
                            <td><?= $estagiario->hasValue('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno_id]) : '' ?>
                            </td>
                            <td><?= $estagiario->registro ?></td>
                            <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                            <td><?= h($estagiario->turno) ?></td>
                            <td><?= h($estagiario->nivel) ?></td>
                            <td><?= $estagiario->tc ?></td>
                            <td><?= date('d-m-Y', strtotime(h($estagiario->tc_solicitacao))) ?></td>

                            <td><?= $estagiario->hasValue('instituicao') ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?>
                            </td>

                            <td><?= $estagiario->hasValue('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?>
                            </td>

                            <td><?= $estagiario->hasValue('professor') ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?>
                            </td>

                            <td><?= h($estagiario->periodo) ?></td>

                            <td><?= $estagiario->hasValue('turmaestagio') ? $this->Html->link($estagiario->turmaestagio->area, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio->id]) : '' ?>
                            </td>

                            <td><?= $estagiario->complemento_id ?>
                            </td>

                            <td><?= $this->Number->format($estagiario->nota, ['precision' => 2]) ?></td>
                            <td><?= $this->Number->format($estagiario->ch) ?></td>
                            <td><?= h($estagiario->observacoes) ?></td>
                            <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
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
</div>