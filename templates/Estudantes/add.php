<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
// pr($registro);
// pr($email);
// die();
?>

<?= $this->element('templates') ?>
<div class="container">
    <?php if ($this->getRequest()->getAttribute('identity')->get('categoria_id') == '1'): ?>
        <?= $this->Html->link(__('Listar estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
    <?php endif; ?>
    <div class="row">
        <div class="col bg-light text-black">
            <?= $this->Form->create($estudante, ['method' => 'post']) ?>
            <fieldset>
                <legend><?= __('Cadastro de Estudante') ?></legend>
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
</div>