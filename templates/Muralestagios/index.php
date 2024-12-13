<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
// pr($periodo);
// pr($muralestagios);
?>
<?php
/*
  var url = "<?= $this->Html->url(['controller' => 'Murals', 'action' => 'index/periodo:']); ?>";
 */
?>
<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'muralestagios', 'action' => 'index?periodo=']); ?>";
        // alert(url);
        $("#MuralestagioPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + periodo;
        })
    })
</script>

<?php $usuario = $this->getRequest()->getAttribute('identity'); ?>

<div class="container">

    <?php if (isset($usuario) && $usuario['categoria_id'] == '1'): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                    aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <?= $this->element('templates') ?>

    <div class="row">
        <h3><?= __('Mural de estagios') ?></h3>
    </div>


    <div class="row justify-content-center">
        <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
            <h1 style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        <?php elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == '1'): ?>
            <?= $this->Form->create($muralestagios, ['class' => 'form-inline']); ?>
            <div class="form-group row">
                <label class='col-sm-1 col-form-label'>Período</label>
                <div class='col-sm-2'>
                    <?= $this->Form->control('periodo', ['id' => 'MuralestagioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('vagas') ?></th>
                    <th><?= $this->Paginator->sort('beneficios') ?></th>
                    <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                    <th><?= $this->Paginator->sort('cargaHoraria', 'CH') ?></th>
                    <th><?= $this->Paginator->sort('dataInscricao', 'Encerramento das Inscrições') ?></th>
                    <th><?= $this->Paginator->sort('dataSelecao', 'Seleção') ?></th>
                    <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
                    <?php elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == '1'): ?>
                        <th class="actions"><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($muralestagios as $muralestagio): ?>
                    <tr>
                        <td><?= $muralestagio->id ?></td>
                        <td><?= $muralestagio->hasValue('instituicao') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) : $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]); ?>
                        </td>
                        <td><?= $muralestagio->vagas ?></td>
                        <td><?= h($muralestagio->beneficios) ?></td>
                        <td><?= (h($muralestagio->final_de_semana) == 0) ? 'Não' : 'Sim' ?></td>
                        <td><?= $muralestagio->cargaHoraria ?></td>
                        <td><?= isset($muralestagio->dataInscricao) ? $muralestagio->dataInscricao : '' ?></td>
                        <td><?= isset($muralestagio->dataSelecao) ? $muralestagio->dataSelecao : '' ?></td>
                        <?php if (is_null($this->getRequest()->getAttribute('identity'))): ?>
                        <?php elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == '1'): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralestagio->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza quer quer excluir este registro # {0}?', $muralestagio->id)]) ?>
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