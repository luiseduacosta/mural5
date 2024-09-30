<?php
$user = $this->getRequest()->getAttribute('identity');
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?= $this->Html->link(__('Listar Alunos'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
<?=
$this->Form->postLink(
        __('Excluir'),
        ['action' => 'delete', $aluno->id],
        ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $aluno->id), 'class' => 'btn btn-danger float-end']
)
?>

<?= $this->element('templates'); ?>
<div class="column-responsive column-80">
    <div class="alunos form content">
        <?= $this->Form->create($aluno) ?>
        <fieldset>
            <legend><?= __('Editar Aluno') ?></legend>
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
</div>
