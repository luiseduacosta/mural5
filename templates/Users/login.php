<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>

<div class="row">
    <div class="col-lg-4 order-lg-1 order-2">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Digite seu usuário e senha') ?></legend>
            <?= $this->Form->control('email', ['required' => true, 'class' => 'form-control']) ?>
            <?= $this->Form->control('password', ['label' => ['text' => 'Senha'], 'required' => true, 'class' => 'form-control']) ?>
        </fieldset>
        <?= $this->Form->submit(__('Login'), ['class' => 'btn btn-success']); ?>
        <?= $this->Form->end() ?>
        <div class="row">
            <div class="col">
                <?= $this->Html->link("Cadastrar novo usuário", ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link("Esqueceu a senha?", ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <div class='col-lg-8 order-lg-2 order-1'>
        <p>
            Prezadas(os) usuárias(os),
            <br />
            <br />
            O Mural de Estágio tem a função de: permitir a consulta e inscrição em vagas de estágio; retirar o Termo de
            Compromisso, folha de atividades, avaliação do/a supervisor/a, declaração de estágio, dentre outros.
            <br />
            <br />
            É a sua primeira vez por aqui? Faça o cadastro com dados completos. Não abrevie seu nome.
            <br />
            <br />
            Vai retirar o Termo de Compromisso? Preencha os dados da supervisão de campo e do/a professor de OTP.
            <br />
            <br />
            Supervisores/as e professores também podem fazer o cadastro e contribuir para mantermos atualizados os dados
            das instituições, assim como seus dados profissionais, incluindo e-mail e telefone.
            <br />
            <br />
            Ficou alguma dúvida? Escreva um e-mail detalhado para: estagio@ess.ufrj.br . Estamos à disposição.
            <br />
            <br />
        <p style="text-align: right">Coordenação de Estágio</p>
    </div>
</div>
</div>