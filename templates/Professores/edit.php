<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
?>

<div class="container">

    <?php if ($this->getRequest()->getAttribute('identity')['categoria'] == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
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
                    <?= $this->Html->link(__('Listar Professores'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($professor) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar professor(a)') ?></legend>
        <?php
        /** Dados pessoais */
        echo $this->Form->control('nome', ['label' => ['text' => 'Nome']]);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'value' => $professor->cpf, 'readonly' => false, 'pattern' => '\d{3}\.\d{3}\.\d{3}-\d{2}', 'placeholder' => '000.000.000-00', 'required' => true]);
        echo $this->Form->control('datanascimento', ['empty' => false, 'label' => ['text' => 'Data de Nascimento']]);
        echo $this->Form->control('localnascimento', ['label' => ['text' => 'Local de Nascimento']]);
        echo $this->Form->control('sexo', ['options' => ['0' => 'Feminino', '1' => 'Masculino', '2' => 'Não informado'], 'default' => '0', 'label' => ['text' => 'Sexo']]);
        /** Dados funcionais */
        echo $this->Form->control('siape', ['readonly' => false, 'label' => ['text' => 'SIAPE']]);
        echo $this->Form->control('dataingresso', ['empty' => true, 'label' => ['text' => 'Data de Ingresso']]);
        echo $this->Form->control('formaingresso', ['label' => ['text' => 'Forma de Ingresso'], 'options' => ['Concurso público' => 'Concurso público', 'Livre-docente' => 'Livre-docente', 'outro' => 'Outro']]);
        echo $this->Form->control('tipocargo', ['label' => ['text' => 'Tipo de Cargo'], 'options' => ['efetivo' => 'Efetivo(a)', 'substituto' => 'Substituto(a)', 'temporario' => 'Temporário(a)', 'outro' => 'Outro']]);
        echo $this->Form->control('categoria', ['label' => ['text' => 'Categoria'], 'options' => ['auxiliar' => 'Auxiliar', 'assistente' => 'Assistente', 'adjunto' => 'Adjuno', 'associado' => 'Associado', 'titular' => 'Titular', 'outro' => 'Outro']]);
        echo $this->Form->control('regimetrabalho', ['label' => ['text' => 'Regime de Trabalho'], 'options' => ['20' => '20 horas', '40' => '40 horas', '40DE' => 'Dedicação Exclusiva', 'outro' => 'Outro']]);
        echo $this->Form->control('departamento', ['label' => ['text' => 'Departamento'], 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['empty' => true, 'label' => ['text' => 'Data de Egresso']]);
        echo $this->Form->control('motivoegresso', ['label' => ['text' => 'Motivo de Egresso'], 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro']]);
        /** Dados de endereço */
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro']]);
        echo $this->Form->control('cidade', ['label' => ['text' => 'Cidade']]);
        echo $this->Form->control('estado', ['label' => ['text' => 'Estado']]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'pattern' => '\d{5}-\d{3}', 'placeholder' => '00000-000', 'keypress()','required' => false]);
        echo $this->Form->control('pais', ['label' => ['text' => 'País']]);
        /** Dados de contato */
        echo $this->Form->control('ddd_telefone', ['label' => ['text' => 'DDD do Telefone']]);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone']]);
        echo $this->Form->control('ddd_celular', ['label' => ['text' => 'DDD do Celular']]);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular']]);
        echo $this->Form->control('email', ['label' => ['text' => 'E-mail']]);
        echo $this->Form->control('homepage', ['label' => ['text' => 'Homepage']]);
        echo $this->Form->control('redesocial', ['label' => ['text' => 'Rede Social']]);
        /** Dados de currículos */
        echo $this->Form->control('curriculolattes', ['label' => ['text' => 'Currículo Lattes']]);
        echo $this->Form->control('atualizacaolattes', ['empty' => true, 'label' => ['text' => 'Atualização Lattes']]);
        echo $this->Form->control('curriculosigma', ['label' => ['text' => 'Currículo Sigma']]);
        echo $this->Form->control('pesquisadordgp', ['label' => ['text' => 'Pesquisador DGP']]);
        /** Dados de graduação */
        echo $this->Form->control('formacaoprofissional', ['label' => ['text' => 'Formação Profissional']]);
        echo $this->Form->control('graduacaoarea', ['label' => ['text' => 'Área de Graduação']]);
        echo $this->Form->control('universidadedegraduacao', ['label' => ['text' => 'Universidade de Graduação']]);
        echo $this->Form->control('anoformacao', ['label' => ['text' => 'Ano de Formação']]);
        /** Dados de pós-graduação */
        echo $this->Form->control('mestradoarea', ['label' => ['text' => 'Área de Mestrado']]);
        echo $this->Form->control('mestradouniversidade', ['label' => ['text' => 'Universidade de Mestrado']]);
        echo $this->Form->control('mestradoanoconclusao', ['label' => ['text' => 'Ano de Conclusão do Mestrado']]);
        echo $this->Form->control('doutoradoarea', ['label' => ['text' => 'Área de Doutorado']]);
        echo $this->Form->control('doutoradouniversidade', ['label' => ['text' => 'Universidade de Doutorado']]);
        echo $this->Form->control('doutoradoanoconclusao', ['label' => ['text' => 'Ano de Conclusão do Doutorado']]);
        /** Outras informações */
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Outra inoformações']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>