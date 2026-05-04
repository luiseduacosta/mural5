<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'index']); ?>";
        // alert(url);
        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = url + '/index?periodo=' + periodo;
        })

        $("#EstagiarioNivel").change(function () {
            var nivel = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&nivel=' + nivel;
        })

        $("#EstagiarioInstituicao").change(function () {
            var instituicao = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&instituicao=' + instituicao;
        })

        $("#EstagiarioSupervisor").change(function () {
            var supervisor = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&supervisor=' + supervisor;
        })

        $("#EstagiarioProfessor").change(function () {
            var professor = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&professor=' + professor;
        })

    })
</script>


<div class='container'>

    <?php if ($user_data['categoria'] === '1'): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo(a) estagiário(a)'), ['action' => 'add'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <?php if ($user_data['categoria'] === '1'): ?>

        <h3><?= __('Estagiario(a)s') ?></h3>

        <div class="row mb-3">
            <div class="col-sm-1">
                <div class="form-group">
                    <?= $this->Form->control('periodo', ['id' => 'EstagiarioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
                </div>
            </div>

            <?php $niveis = ['1' => '1º', '2' => '2º', '3' => '3º', '4' => '4º', '9' => 'Não curricular']; ?>

            <div class="col-sm-1">
                <div class="form-group">
                    <?= $this->Form->control('nivel', ['id' => 'EstagiarioNivel', 'type' => 'select', 'label' => false, 'options' => $niveis, 'empty' => 'Nível', 'class' => 'form-control']); ?>
                </div>
            </div>

            <?php if (!empty($instituicoes)): ?>
                <div class="col-sm-2">
                    <div class="form-group">
                        <?= $this->Form->control('instituicao_id', ['id' => 'EstagiarioInstituicao', 'type' => 'select', 'label' => false, 'options' => $instituicoes, 'empty' => 'Instituição', 'class' => 'form-control']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($supervisores)): ?>
                <div class="col-sm-2">
                    <div class="form-group">
                        <?= $this->Form->control('supervisor_id', ['id' => 'EstagiarioSupervisor', 'type' => 'select', 'label' => false, 'options' => $supervisores, 'empty' => 'Supervisor(a)', 'class' => 'form-control']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($professores)): ?>
                <div class="col-sm-2">
                    <div class="form-group">
                        <?= $this->Form->control('professor_id', ['id' => 'EstagiarioProfessor', 'type' => 'select', 'label' => false, 'options' => $professores, 'empty' => 'Professor(a)', 'class' => 'form-control']); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

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
                        <th><?= $this->Paginator->sort('nivel') ?></th>
                        <th><?= $this->Paginator->sort('tc', 'Termo de compromisso') ?></th>
                        <th><?= $this->Paginator->sort('tc_solicitacao', 'Data TC') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituicoes') ?></th>
                        <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                        <th><?= $this->Paginator->sort('Professores.nome', 'Professor/a') ?></th>
                        <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                        <th><?= $this->Paginator->sort('Complemento.id', 'Tipo') ?></th>
                        <?php if ($user_data['categoria'] === '1'): ?>
                            <th><?= $this->Paginator->sort('nota') ?></th>
                            <th><?= $this->Paginator->sort('ch', 'Carga horária') ?></th>
                        <?php endif; ?>
                        <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                        <?php if ($user_data['categoria'] === '1'): ?>
                            <th class="actions"><?= __('Ações') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estagiarios as $estagiario): ?>
                        <tr>
                            <td><?= $estagiario->id ?></td>
                            <td><?= $estagiario->hasValue('aluno') ? $this->Html->link($estagiario->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno_id]) : '' ?>
                            </td>
                            <td><?= $estagiario->registro ?></td>
                            <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                            <td><?= h($estagiario->nivel) ?></td>
                            <td><?= $estagiario->tc ?></td>
                            <td><?= $estagiario->tc_solicitacao ? date('d-m-Y', strtotime(h($estagiario->tc_solicitacao))) : '' ?>
                            </td>

                            <td><?= $estagiario->hasValue('instituicao') ? $this->Html->link($estagiario->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao->id]) : '' ?>
                            </td>

                            <td><?= $estagiario->hasValue('supervisor') ? $this->Html->link($estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor->id]) : '' ?>
                            </td>

                            <td><?= $estagiario->hasValue('professor') ? $this->Html->link($estagiario->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiario->professor->id]) : '' ?>
                            </td>

                            <td><?= h($estagiario->periodo) ?></td>

                            <td><?= $estagiario->complemento_id ?>
                            </td>
                            <?php if ($user_data['categoria'] === '1'): ?>
                                <?php if (isset($estagiario->nota)): ?>
                                    <td><?= $this->Number->format($estagiario->nota, ['precision' => 2]) ?></td>
                                <?php else: ?>
                                    <td>Sem nota</td>
                                <?php endif; ?>
                                <td><?= $this->Number->format($estagiario->ch) ?></td>
                            <?php endif; ?>
                            <td><?= h($estagiario->observacoes) ?></td>
                            <?php if ($user_data['categoria'] === '1'): ?>
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
        <?= $this->element('paginator') ?>
    </div>
</div>