<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
$usuario = $this->getRequest()->getAttribute('identity');
?>
<?= $this->element('templates') ?>
<div class='container'>
    <div class="row">
        <?php if ($usuario->get('categoria') == 1): ?>
            <?= $this->Html->link(__('List Estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $estudante->id],
                    ['confirm' => __('Tem certeza que quer excluir este registro {0}?', $estudante->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
        <?php endif; ?>
    </div>
    <div class="container">
        <?= $this->Form->create($estudante) ?>
        <fieldset>
            <legend><?= __('Editar Estudante') ?></legend>
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