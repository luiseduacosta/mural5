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

<div class="container">

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar visita'), ['controller' => 'Visitas', 'action' => 'edit', $visita->id], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
            </li>
            <li class='nav-item'>
                <?= $this->Form->postLink(__('Excluir visita'), ['controller' => 'Visitas', 'action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que deseja excluir este registro de visita {0}?', $visita->id), 'class' => 'btn btn-danger me-1', 'style' => 'font-size: 10pt;']) ?>
            </li>
            <li class='nav-item'>
                <?= $this->Html->link(__('Nova visita'), ['controller' => 'Visitas', 'action' => 'add'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar visitas'), ['controller' => 'Visitas', 'action' => 'index'], ['class' => 'btn btn-primary me-1', 'style' => 'font-size: 10pt;']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($visita->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Instituição') ?></th>
            <td><?= $visita->has('instituicao') ? $this->Html->link($visita->instituicao['instituicao'], ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Motivo') ?></th>
            <td><?= h($visita->motivo) ?></td>
        </tr>
        <tr>
            <th><?= __('Responsável') ?></th>
            <td><?= h($visita->responsavel) ?></td>
        </tr>
        <tr>
            <th><?= __('Avaliação') ?></th>
            <td><?= h($visita->avaliacao) ?></td>
        </tr>
        <tr>
            <th><?= __('Data') ?></th>
            <td><?= h($visita->data) ?></td>
        </tr>
    </table>
    <div class="text">
        <strong><?= __('Descrição') ?></strong>
        <blockquote>
            <?= $this->Text->autoParagraph(h($visita->descricao)); ?>
        </blockquote>
    </div>
</div>