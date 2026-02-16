<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?php
$submit = [
    "button" => "<div class='d-flex justify-content-center'><button type ='submit' class= 'btn btn-danger' {{attrs}}>{{text}}</button></div>"
]
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
                    <?= $this->Html->link(__('Listar aluno(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary me-1'])
                    ?>
                </li>
<?php endif; ?>
            </ul>
        </div>
    </nav>

    <?= $this->Form->create($aluno) ?>
    <fieldset>
        <legend><?= __('Declaração de ' . $totalperiodos . 'º' . ' período do(a) aluno') ?></legend>
        <?php
        if ($aluno->periodonovo):
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno->periodonovo]);
        else:
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno->ingresso]);
        endif;
        echo $this->Form->control('nome', ['readonly' => true]);
        echo $this->Form->control('nomesocial', ['label' => ['text' => 'Nome social']]);
        echo $this->Form->control('registro', ['readonly' => true]);
        echo $this->Form->control('ingresso', ['readonly' => true]);
        echo $this->Form->control('turno', ['options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno']]);
        echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'DDD']]);
        echo $this->Form->control('telefone');
        echo $this->Form->control('codigo_celular', ['label' => ['text' => 'DDD']]);
        echo $this->Form->control('celular');
        echo $this->Form->control('email');
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF']]);
        echo $this->Form->control('identidade', ['label' => ['text' => 'Carteira de identidade']]);
        echo $this->Form->control('orgao', ['label' => ['text' => 'Orgão emissor']]);
        echo $this->Form->control('nascimento', ['empty' => true]);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP']]);
        echo $this->Form->control('municipio');
        echo $this->Form->control('bairro');
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <div class="btn-group" role="group" aria-label="Confirma">
            <?= $this->Html->link('Imprime PDF', ['action' => 'certificadoperiodopdf', '?' => ['id' => $aluno->id, 'totalperiodos' => $totalperiodos]], ['class' => 'btn btn-lg btn-primary', 'rule' => 'button']); ?>
            <?php $this->Form->setTemplates($submit); ?>
            <?= $this->Form->button(__('Confirmar alteraçoes'), ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>