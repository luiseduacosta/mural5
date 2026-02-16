<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
?>

<?= $this->element('templates') ?>

<div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerEstagiario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <?php if($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?=
                            $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $professor->id],
                                ['confirm' => __('Tem certeza de excluir # {0}?', $professor->id), 'class' => 'btn btn-danger me-1']
                            )
                            ?>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar professores'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                </ul>
            </div>
        </nav>

    <div class="container">
        <?= $this->Form->create($professor) ?>
        <fieldset>
            <legend><?= __('Editar professor') ?></legend>
            <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('cpf');
            echo $this->Form->control('siape');
            echo $this->Form->control('datanascimento', ['empty' => true]);
            echo $this->Form->control('localnascimento');
            echo $this->Form->control('sexo');
            echo $this->Form->control('ddd_telefone');
            echo $this->Form->control('telefone');
            echo $this->Form->control('ddd_celular');
            echo $this->Form->control('celular');
            echo $this->Form->control('email');
            echo $this->Form->control('homepage');
            echo $this->Form->control('redesocial');
            echo $this->Form->control('curriculolattes');
            echo $this->Form->control('atualizacaolattes', ['empty' => true]);
            echo $this->Form->control('curriculosigma');
            echo $this->Form->control('pesquisadordgp');
            echo $this->Form->control('formacaoprofissional');
            echo $this->Form->control('universidadedegraduacao');
            echo $this->Form->control('anoformacao');
            echo $this->Form->control('mestradoarea');
            echo $this->Form->control('mestradouniversidade');
            echo $this->Form->control('mestradoanoconclusao');
            echo $this->Form->control('doutoradoarea');
            echo $this->Form->control('doutoradouniversidade');
            echo $this->Form->control('doutoradoanoconclusao');
            echo $this->Form->control('dataingresso', ['empty' => true]);
            echo $this->Form->control('formaingresso');
            echo $this->Form->control('tipocargo');
            echo $this->Form->control('categoria');
            echo $this->Form->control('regimetrabalho');
            echo $this->Form->control('departamento');
            echo $this->Form->control('dataegresso', ['empty' => true]);
            echo $this->Form->control('motivoegresso');
            echo $this->Form->control('observacoes');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>