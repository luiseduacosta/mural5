<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <?php if ($user_data['categoria'] === '1'): ?>
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $complemento->id],
                    ['confirm' => __('Tem certeza que quer excluir # {0}?', $complemento->id), 'class' => 'btn btn-danger me-2', 'style' => 'font-size: 10pt;']
                )
            ?>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar complemento do estágio'), ['action' => 'index'], ['class' => 'btn btn-primary me-2 float-end', 'style' => 'font-size: 10pt;']) ?>
        </li>
    </ul>
</nav>

<div class="container">
    <?= $this->Form->create($complemento) ?>
    <fieldset>
        <legend><?= __('Editar complemento de estágio') ?></legend>
        <?php if ($user_data['categoria'] === '1'): ?>
            <?php
            echo $this->Form->control('periodo_especial', ['label' => 'Período especial']);
            ?>
        <?php endif; ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
