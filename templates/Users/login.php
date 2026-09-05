<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->Html->css('login', ['block' => true]);
?>

<?= $this->element('templates') ?>

<?php
// Form templates scoped to this page so the login card matches DESIGN.md.
$this->Form->setTemplates([
    'formGroup' => '{{label}}{{input}}',
    'label' => '<label{{attrs}}>{{text}}</label>',
    'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}>',
    'inputContainer' => '<div class="login-field"{{attrs}}>{{content}}</div>',
    'inputContainerError' => '<div class="login-field error"{{attrs}}>{{content}}{{error}}</div>',
]);
?>

<div class="login-page">
    <div class="login-card">
        <div class="login-card-header">
            <h1><?= __('Mural de Estágios') ?></h1>
            <p><?= __('ESS/UFRJ — Estágio Supervisionado') ?></p>
        </div>
        <div class="login-card-body">
            <h2><?= __('Acesso ao sistema') ?></h2>
            <p class="login-subtitle"><?= __('Por favor informe seu usuário e senha') ?></p>

            <?= $this->Form->create(null, ['class' => 'login-form']) ?>
                <?= $this->Form->control('email', [
                    'type' => 'email',
                    'label' => __('Usuário'),
                    'placeholder' => __('Seu e-mail'),
                    'required' => true,
                    'autocomplete' => 'username',
                ]) ?>
                <?= $this->Form->control('password', [
                    'label' => __('Senha'),
                    'placeholder' => __('Sua senha'),
                    'required' => true,
                    'autocomplete' => 'current-password',
                ]) ?>
                <?= $this->Form->button(__('Login'), ['class' => 'btn-login', 'type' => 'submit']) ?>
            <?= $this->Form->end() ?>

            <div class="login-footer-actions">
                <?= $this->Html->link(__('Esqueceu a senha?'), ['action' => 'add'], ['class' => 'link']) ?>
                <?= $this->Html->link(__('Cadastro de novo usuário(a)'), ['action' => 'add'], ['class' => 'btn-outline']) ?>
            </div>
        </div>
    </div>
</div>
