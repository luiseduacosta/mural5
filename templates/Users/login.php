<?php
/**
 * @var \App\View\AppView $this
 * @var \Authentication\Authenticator\ResultInterface $user
 */

$this->assign('title', __('Acesso ao mural'));

$this->Html->css('login', ['block' => true]);
$periodoAtual = isset($configuracao) && !empty($configuracao['mural_periodo_atual'])
    ? $configuracao['mural_periodo_atual']
    : null;
?>

<div class="login-cover">
    <div class="login-cover-top">
        <div class="login-brand">
            <svg width="34" height="34" viewBox="0 0 96 96" aria-hidden="true">
                <rect x="10" y="10" width="76" height="76" rx="20" fill="none" stroke="#ffffff" stroke-width="5"/>
                <rect x="30" y="24" width="34" height="48" rx="9" fill="#ffffff" opacity=".38"/>
                <rect x="42" y="36" width="34" height="44" rx="9" fill="#ffffff"/>
                <circle cx="59" cy="28" r="8.5" fill="none" stroke="#1d4f7a" stroke-width="5.5"/>
                <circle cx="59" cy="28" r="2.1" fill="#1d4f7a"/>
            </svg>
            <span>
                <b><?= __('Mural de Estágios') ?></b>
                <span class="mini">ESS · UFRJ</span>
            </span>
        </div>
        <?php if ($periodoAtual !== null) { ?>
            <span class="login-chip"><i></i><?= __('Período {0} · Coordenação de Estágio', h($periodoAtual)) ?></span>
        <?php } ?>
    </div>

    <div class="login-cover-grid">
        <div class="login-hero">
            <svg width="112" height="112" viewBox="0 0 96 96" role="img" aria-label="Símbolo do Mural de Estágios">
                <rect x="10" y="10" width="76" height="76" rx="20" fill="none" stroke="#ffffff" stroke-width="5"/>
                <rect x="30" y="24" width="34" height="48" rx="9" fill="#ffffff" opacity=".38"/>
                <rect x="42" y="36" width="34" height="44" rx="9" fill="#ffffff"/>
                <circle cx="59" cy="28" r="8.5" fill="none" stroke="#1d4f7a" stroke-width="5.5"/>
                <circle cx="59" cy="28" r="2.1" fill="#1d4f7a"/>
            </svg>
            <p class="eyebrow"><?= __('Universidade Federal do Rio de Janeiro') ?></p>
            <h1><?= __('Mural') ?> <span class="w2"><?= __('de Estágios') ?></span></h1>
            <p class="tagline">
                <?= __('O quadro digital de estágios da Escola de Serviço Social — ') ?>
                <?= __('acompanhamento de alunos, vagas, termos e declarações em um só lugar.') ?>
            </p>
            <div class="login-roles" aria-label="<?= __('Públicos do mural') ?>">
                <span><?= __('Alunos') ?></span>
                <span><?= __('Professores') ?></span>
                <span><?= __('Supervisores') ?></span>
                <span><?= __('Coordenação') ?></span>
            </div>
        </div>

        <div class="login-card" aria-labelledby="login-card-title">
            <h2 id="login-card-title"><?= __('Acesso ao mural') ?></h2>
            <p class="sub"><?= __('Entre com seu e-mail institucional para acompanhar ') ?><?= __('estágios, documentos e vagas.') ?></p>

            <?= $this->Form->create(null, ['novalidate' => true]) ?>
                <?= $this->Form->control('email', [
                    'type' => 'email',
                    'label' => __('E-mail institucional'),
                    'placeholder' => 'nome@ess.ufrj.br',
                    'required' => true,
                    'autocomplete' => 'username',
                ]) ?>
                <?= $this->Form->control('password', [
                    'label' => __('Senha'),
                    'placeholder' => __('Sua senha'),
                    'required' => true,
                    'autocomplete' => 'current-password',
                ]) ?>
                <?= $this->Form->button(__('Entrar no sistema'), ['type' => 'submit', 'class' => 'login-btn']) ?>
            <?= $this->Form->end() ?>

            <div class="login-divider"><?= __('ou') ?></div>

            <?= $this->Html->link(
                __('Cadastro de novo usuário(a)'),
                ['action' => 'add'],
                ['class' => 'login-btn-ghost']
            ) ?>
            <div class="login-links">
                <?= $this->Html->link(__('Esqueceu a senha?'), ['action' => 'add']) ?>
            </div>
        </div>
    </div>
</div>

<div class="login-foot">
    <b><?= __('Mural de Estágios') ?></b> ·
    <?= __('Escola de Serviço Social — Universidade Federal do Rio de Janeiro') ?><br>
    © <?= date('Y') ?> <?= __('Coordenação de Estágio · uso restrito à comunidade ESS/UFRJ') ?>
</div>
