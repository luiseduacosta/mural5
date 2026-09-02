<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscricao[]|\Cake\Collection\CollectionInterface $inscricoes
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

        var url = "<?= $this->Html->Url->build(['controller' => 'inscricoes', 'action' => 'index?periodo=']); ?>";
        // alert(url);
        $("#InscricoesPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + periodo;
        })

    })
</script>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <?php if ($user_data['categoria'] === '1'): ?>
                <?= $this->Form->create($inscricoes, ['class' => 'd-flex align-items-center gap-2 mb-0']); ?>
                <label class="fw-semibold mb-0">Período</label>
                <?= $this->Form->control('periodo', ['id' => 'InscricoesPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-select']); ?>
                <?= $this->Form->end(); ?>
            <?php else: ?>
                <h1 class="h3 mb-0 text-center text-md-start">Inscrições para seleção de estágio da ESS/UFRJ. Período: <?= $periodo; ?></h1>
            <?php endif; ?>
        </div>
        <?php if (($user_data['categoria'] === '1') || $user_data['aluno_id']): ?>
            <div>
                <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('registro', 'Registro') ?></th>
                            <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                            <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituição') ?></th>
                            <th><?= $this->Paginator->sort('data') ?></th>
                            <th><?= $this->Paginator->sort('periodo') ?></th>
                            <th><?= $this->Paginator->sort('timestamp', 'Atualizado') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscricoes as $inscricao): ?>
                            <tr>
                                <td><?= $inscricao->id ?></td>
                                <td><?= $inscricao->registro ?></td>
                                <?php if ($user_data['categoria'] === '1'): ?>
                                    <td><?= $inscricao->has('aluno') ? $this->Html->link($inscricao->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscricao->aluno_id]) : '' ?></td>
                                <?php else: ?>
                                    <td><?= $inscricao->has('aluno') ? $inscricao->aluno->nome : '' ?></td>
                                <?php endif; ?>
                                <td><?= $inscricao->has('muralestagio') ? $this->Html->link($inscricao->muralestagio->instituicao_entidade->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $inscricao->muralestagio_id]) : '' ?></td>
                                <td><?= $inscricao->data ? $inscricao->data->format('d/m/Y') : '' ?></td>
                                <td><?= h($inscricao->periodo) ?></td>
                                <td><?= $inscricao->timestamp ? $inscricao->timestamp->format('d/m/Y H:i:s') : '' ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $inscricao->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?php if (($user_data['categoria'] === '1') || $user_data['aluno_id']): ?>
                                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $inscricao->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $inscricao->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $inscricao->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <div class="paginator text-center">
            <ul class="pagination mb-2">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p class="mb-0 text-muted"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </div>
</div>
</div>
