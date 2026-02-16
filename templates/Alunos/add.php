<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?= $this->element('templates') ?>

<div class="container">
    
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
<?php if($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar aluno(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
<?php endif; ?>
                </ul>
            </div>
        </nav>

    <div class="container">

    <?= $this->Form->create($aluno, ['method' => 'post']) ?>
        <fieldset>
            <legend><?= __('Cadastro de aluno(a)') ?></legend>
            <?php
            echo $this->Form->control('nome', ['required']);
            echo $this->Form->control('nomesocial', ['label' => ['text' => 'Nome social']]);
            if (isset($registro)):
                echo $this->Form->control('registro', ['value' => $registro, 'readonly', 'required']);
            else:
                echo $this->Form->control('registro', ['required']);
            endif;
            echo $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso: aaaa-n'], 'pattern' => '\d{4}-[1-2]{1}', 'placeholder' => '____-_', 'required']);
            echo $this->Form->control('turno', ['label' => ['text' => 'Turno'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'required']);
            echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'DDD']]);
            echo $this->Form->control('telefone');
            echo $this->Form->control('codigo_celular', ['label' => ['text' => 'DDD']]);
            echo $this->Form->control('celular', ['pattern' => '\d{5}.\d{4}', 'placeholder' => '_____.____']);
            if (isset($email)):
                echo $this->Form->control('email', ['value' => $email, 'readonly', 'required']);
            else:
                echo $this->Form->control('email', ['required']);
            endif;
            echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'pattern' => '\d{9}-\d{2}', 'placeholder' => '_________-__', 'required']);
            echo $this->Form->control('identidade', ['label' => ['text' => 'Carteira de identidade'], 'required']);
            echo $this->Form->control('orgao', ['label' => ['text' => 'Orgão emissor'], 'required']);
            echo $this->Form->control('nascimento', ['type' => 'date', 'empty' => true]);
            echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'pattern' => '\d{5}-\d{3}', 'placeholder' => '_____-___']);
            echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
            echo $this->Form->control('municipio', ['label' => ['text' => 'Município']]);
            echo $this->Form->control('bairro');
            echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>