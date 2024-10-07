<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao[]|\Cake\Collection\CollectionInterface $inscricoes
 */
// pr($inscricoes);
// pr($periodo);
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'inscricoes', 'action' => 'index?periodo=']); ?>";
        // alert(url);
        $("#InscricoesPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + periodo;
        })

    })
</script>

<?php
?>

<div class="row justify-content-center">
    <div class="col-auto">
        <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
            <?= $this->Form->create($inscricoes, ['class' => 'form-inline']); ?>
            <?= $this->Form->input('periodo', ['id' => 'InscricoesPeriodo', 'type' => 'select', 'label' => ['text' => 'Período ', 'style' => 'display: inline;'], 'options' => $periodos, 'empty' => [$periodo => $periodo]], ['class' => 'form-control']); ?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Inscrições para seleção de estágio da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <h3><?= __('Inscrições para seleção de estágio') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('registro', 'Registro') ?></th>
                    <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                    <th><?= $this->Paginator->sort('Muralestagios.instituicao', 'Instituição') ?></th>
                    <th><?= $this->Paginator->sort('data') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('timestamp') ?></th>
                    <th class="actions"><?= __('Açoes') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscricoes as $inscricao): ?>
                    <tr>
                        <td><?= $inscricao->id ?></td>
                        <td><?= $inscricao->registro ?></td>
                        <td><?= $inscricao->has('estudante') ? $this->Html->link($inscricao->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $inscricao->estudante_id]) : '' ?>
                        </td>
                        <td><?= $inscricao->has('muralestagio') ? $this->Html->link($inscricao->muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio->id]) : '' ?>
                        </td>
                        <td><?= date('d-m-Y', strtotime(h($inscricao->data))) ?></td>
                        <td><?= h($inscricao->periodo) ?></td>
                        <td><?= h($inscricao->timestamp) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $inscricao->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $inscricao->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id)]) ?>
                        </td>
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

            </p>
        </div>
    </div>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
</div>