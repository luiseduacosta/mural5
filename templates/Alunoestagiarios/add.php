<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Alunoestagiario $alunoestagiario
 */
// pr($registro);
// die();
?>

<?php $user = $this->getRequest()->getAttribute('identity'); ?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar aluno(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <?= $this->element('templates'); ?>

    <div class="container">
        <?= $this->Form->create($alunoestagiario) ?>
        <fieldset>
            <legend><?= __('Novo alunoestagiario') ?></legend>
            <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('registro');
            echo $this->Form->control('nascimento', ['empty' => true]);
            echo $this->Form->control('cpf');
            echo $this->Form->control('identidade');
            echo $this->Form->control('orgao');
            echo $this->Form->control('email');
            echo $this->Form->control('codigo_telefone');
            echo $this->Form->control('telefone');
            echo $this->Form->control('codigo_celular');
            echo $this->Form->control('celular');
            echo $this->Form->control('cep');
            echo $this->Form->control('endereco');
            echo $this->Form->control('municipio');
            echo $this->Form->control('bairro');
            echo $this->Form->control('observacoes');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>