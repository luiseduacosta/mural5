<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<?= $this->element('templates') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
            <li class="nav-item">
            <?=
            $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $visita->id],
                ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $visita->id), 'class' => 'btn btn-danger me-1', 'style' => 'font-size: 10pt;']
            )
            ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary', 'style' => 'font-size: 10pt;']) ?>
        </li>
    </ul>
</nav>

<?php $this->element("templates"); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($visita) ?>
        <fieldset>
            <legend><?= __('Editar visita') ?></legend>
            <?php
            echo $this->Form->control('instituicao_id', ['options' => $instituicoes]);
            echo $this->Form->control('data', ['label' => ['text' => 'Data'], 'class' => 'form-control']);
            echo $this->Form->control('motivo', ['label' => ['text' => 'Motivo'], 'class' => 'form-control']);
            echo $this->Form->control('responsavel', ['label' => ['text' => 'Responsável'], 'class' => 'form-control']);
            echo $this->Form->control('descricao', ['label' => ['text' => 'Descrição'], 'class' => 'form-control']);
            echo $this->Form->control('avaliacao', ['label' => ['text' => 'Avaliação'], 'class' => 'form-control']);
            ?>
        </fieldset>
        <div class="d-flex justify-content-center">
            <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary mt-1']) ?>
        </div>
        <?= $this->Form->end() ?>
</div>
