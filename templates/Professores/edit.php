<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
?>
<div>
    <div class="column-responsive column-80">
        <div class="professores form content">
            <aside>
                <div class="side-nav">
                    <?= $this->Form->postLink(
                        __('Deletar'),
                        ['action' => 'delete', $professor->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $professor->id), 'class' => 'side-nav-item']
                    ) ?>
                    <?= $this->Html->link(__('Listar Professores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                </div>
            </aside>
            <?= $this->Form->create($professor) ?>
            <fieldset>
                <legend><?= __('Editar Professor') ?></legend>
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
                    echo $this->Form->control('regimetrabalho');
                    echo $this->Form->control('departamento');
                    echo $this->Form->control('dataegresso', ['empty' => true]);
                    echo $this->Form->control('motivoegresso');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Editar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
