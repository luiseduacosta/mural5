<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
declare(strict_types=1);

$user_data = ['administrador_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0, 'categoria' => '0'];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <?php if ($user_data['administrador_id']): ?>
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $folhadeatividade->id],
                    ['confirm' => __('Tem certeza que quer excluir esta atividade # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger me-1', 'style' => 'font-size: 10pt;'])
            ?>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Lista de atividades'), ['action' => 'index', $estagiario->id], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
        </li>
    </ul>
</nav>        

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($folhadeatividade) ?>
        <fieldset>
            <legend><?= __('Editar atividade') ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome], 'readonly' => true,
                'templates' => [
                    'label' => '<div class="col-sm-3"><label class="form-label">{{text}}</label></div>',
                    'select' => '<div class="col-sm-9"><select name="{{name}}" class="form-control" {{attrs}}>{{content}}</select></div>',
                ]
            ]);
            echo $this->Form->control('dia', ['label' => __('Dia')]);
            echo $this->Form->control('inicio', ['label' => __('Horário de início')]);
            echo $this->Form->control('final', ['label' => __('Horário de finalização')]);
            echo $this->Form->control('atividade', ['label' => __('Atividade')]);
            echo $this->Form->control('horario', ['type' => 'hidden', 'empty' => true]);
        ?>
        <div class="d-flex justify-content-end">
            <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
</div>