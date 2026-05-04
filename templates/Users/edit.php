<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <?php if ($user_data['categoria'] === '1'): ?>
            <li class="nav-link">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Tem certeza que quer excluir este usuário # {0}?', $user->id), 'class' => 'btn btn-danger float-end me-2', 'style' => 'font-size: 10pt;']
                )
                ?>
            </li>
        <li class="nav-link">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end me-2', 'style' => 'font-size: 10pt;']) ?>
        </li>
        <?php endif; ?>
    </ul>
</nav>

    <div class="container">
        <h3><?= h($user->nome) ?></h3>
        <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Editar usuário') ?></legend>
            <?php
            echo $this->Form->control('entidade_id', ['type' => 'number', 'label' => ['text' => 'Entidade']]);
            echo $this->Form->control('nome',['readonly' => true]);
            echo $this->Form->control('email',['readonly' => true]);
            echo $this->Form->control('password');
            echo $this->Form->control('identificacao', ['label' => ['text' => 'DRE/Siape/CRESS'], 'readonly' => true]);
            echo $this->Form->control('ativo', ['options' => ['1' => 'Sim', '0' => 'Não'], 
                'label' => ['text' => 'Ativo'],
                'readonly' => true]);
            echo $this->Form->control('atualizado_em', ['value' => date('Y-m-d H:i:s'), 'type' => 'hidden']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>