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

<?= $this->element('templates') ?>

<div class="container">

    <?php
    if ($user_data['categoria'] === '1' && $user_data['entidade_id']): ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end', 'style' => 'font-size: 10pt;']); ?>
                    </li>
                </ul>
            </div>
        </nav>

    <?php endif; ?>

    <div class="container">
        <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Cadastro de novo usuário(a)') ?></legend>
            <?php
            echo $this->Form->control('nome', ['label' => ['text' => 'Nome']]);
            echo $this->Form->control('email');
            echo $this->Form->control('password', ['label' => ['text' => 'Senha']]);
            echo $this->Form->control('categoria', ['options' => ['2' => 'Aluno(a)', '3' => 'Professor(a)', '4' => 'Supervisor(a)'],
                'label' => ['text' => 'Categoria'],
                'templates' => [
                    'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                    'label' => '<div class="col-sm-3"><label class="form-label"{{attrs}}>{{text}}</label></div>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                    'option' => '<option value="{{value}}">{{text}}</option>']
                ]);
            echo $this->Form->control('identificacao', ['label' => ['text' => 'DRE, Siape ou CRESS']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']); ?>
        <?= $this->Form->end() ?>
    </div>
</div>