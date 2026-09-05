<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?php
// App-wide Bootstrap form templates: each field renders as a horizontal row
// (label col-sm-3 + control col-sm-9) so labels and inputs stay aligned.
$this->element('templates');
// Vertical rhythm between the horizontal field rows, local to this form.
$this->Form->setTemplates([
    'inputContainer' => '<div class="row col-md-12 mb-3" {{type}}{{required}}">{{content}}</div>',
]);
?>

<div class="d-flex justify-content-start">
    <a href="<?= $this->Url->build(['action' => 'view', $aluno->id]) ?>" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-3">
        <h3><?= __('Declaração de ' . $totalperiodos . 'º' . ' período do(a) aluno') ?></h3>
        <?php
        if ($aluno->periodonovo) :
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno->periodonovo]);
        else :
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno->ingresso]);
        endif;
        echo $this->Form->control('nome', ['readonly']);
        echo $this->Form->control('nomesocial', ['label' => ['text' => 'Nome social']]);
        echo $this->Form->control('registro', ['readonly']);
        echo $this->Form->control('ingresso', ['readonly']);
        echo $this->Form->control('turno_id', ['options' => $turnos]);
        echo $this->Form->control('telefone');
        echo $this->Form->control('celular');
        echo $this->Form->control('email');
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF']]);
        echo $this->Form->control('identidade', ['label' => ['text' => 'Carteira de identidade']]);
        echo $this->Form->control('orgao', ['label' => ['text' => 'Orgão emissor']]);
        echo $this->Form->control('nascimento', [
            'empty' => true,
            'templates' => [
                'dateWidget' => '<div class="col-sm-9 d-flex flex-wrap gap-2">{{day}}{{month}}{{year}}</div>',
                'select' => '<select class="form-select w-auto" name="{{name}}"{{attrs}}>{{content}}</select>',
            ],
        ]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP']]);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
        echo $this->Form->control('municipio');
        echo $this->Form->control('bairro');
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações']]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <div class="btn-group" role="group" aria-label="Confirma">
            <?= $this->Html->link('Imprime PDF', ['action' => 'declaracaoperiodopdf', '?' => ['id' => $aluno->id, 'totalperiodos' => $totalperiodos]], ['class' => 'btn btn-lg btn-primary me-1']); ?>
            <?= $this->Form->button(__('Confirmar alteraçoes'), ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
