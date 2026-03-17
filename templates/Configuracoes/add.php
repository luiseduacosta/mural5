<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
$user = $this->getRequest()->getAttribute('identity');
?>
<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <ul class="navbar-nav collapse navbar-collapse">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar configurações'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($configuracao) ?>
        <fieldset>
            <legend><?= __('Configuração') ?></legend>
            <?php
<<<<<<< HEAD
            echo $this->Form->control('mural_periodo_atual', ['label' => 'Período atual do mural']);
            echo $this->Form->control('termo_compromisso_periodo', ['label' => 'Período do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_inicio', ['label' => 'Início do termo de compromisso']);
            echo $this->Form->control('termo_compromisso_final', ['label' => 'Fim do termo de compromisso']);
            echo $this->Form->control('curso_turma_atual', ['label' => 'Turma atual do curso']);
            echo $this->Form->control('curso_abertura_inscricoes', ['label' => 'Abertura das inscrições do curso']);
            echo $this->Form->control('curso_encerramento_inscricoes', ['label' => 'Encerramento das inscrições do curso']);
=======
            echo $this->Form->control('mural_periodo_atual');
            echo $this->Form->control('termo_compromisso_periodo');
            echo $this->Form->control('termo_compromisso_inicio');
            echo $this->Form->control('termo_compromisso_final');
            echo $this->Form->control('periodo_calendario_academico');
            echo $this->Form->control('curso_turma_atual');
            echo $this->Form->control('curso_abertura_inscricoes');
            echo $this->Form->control('curso_encerramento_inscricoes');
>>>>>>> f24fd5044a46c82646db2ccb8d44e906b708f1fd
            ?>
        </fieldset>
        <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
</div>
