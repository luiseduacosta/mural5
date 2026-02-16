<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?= $this->element('templates') ?>

<div class='container'>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Aluno(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <?php if($user->isAdmin()): ?>
                        <li class="nav-item">
                            <?= $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $aluno->id],
                                ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $aluno->id), 'class' => 'btn btn-danger me-1']
                            )
                                ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

    <div class="container">
        <?= $this->Form->create($aluno) ?>
        <fieldset>
            <legend><?= __('Editar Aluno') ?></legend>
            <?php
            echo $this->Form->control('nome');
            echo $this->Form->control('nomesocial', ['label' => ['text' => 'Nome social']]);
            echo $this->Form->control('registro');
            echo $this->Form->control('ingresso');
            echo $this->Form->control('turno', ['options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno']]);
            echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'DDD']]);
            echo $this->Form->control('telefone');
            echo $this->Form->control('codigo_celular', ['label' => ['text' => 'DDD']]);
            echo $this->Form->control('celular');
            echo $this->Form->control('email');
            echo $this->Form->control('cpf');
            echo $this->Form->control('identidade', ['label' => ['text' => 'Carteira de identidade'], 'required']);
            echo $this->Form->control('orgao', ['label' => ['text' => 'Orgão emissor'], 'required']);
            echo $this->Form->control('nascimento', ['empty' => true]);
            echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
            echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'pattern' => '\d{5}-\d{3}', 'placeholder' => '_____-___']);
            echo $this->Form->control('municipio', ['label' => ['text' => 'Município']]);
            echo $this->Form->control('bairro');
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>