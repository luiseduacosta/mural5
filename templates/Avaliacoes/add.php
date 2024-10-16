<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
// pr($estagiario);
// die();
?>
<?php
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());

if (isset($estagiario->supervisor->nome)) {
    $supervisora = $estagiario->supervisor->nome;
} else {
    $supervisora = "____________________";
}

if (isset($estagiario->supervisor->regiao)) {
    $regiao = $estagiario->supervisor->regiao;
} else {
    $regiao = '__';
}

if (isset($estagiario->supervisor->cress)) {
    $cress = $estagiario->supervisor->cress;
} else {
    $cress = '_____';
}
?>

<style>
    legend {
        font-weight: normal;
        text-align: justify;
    }
</style>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar avaliações'), ['action' => 'index', '?' => ['estagiario_id' => $estagiario->id, 'registro' => $estagiario->registro]], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <h1>Formulário de avalição da(a) discente <?= $estagiario->aluno->nome ?></h1>

    <div class="container">

    <?php $this->element('templates'); ?>

        <?= $this->Form->create($avaliacao) ?>
        <?php
       //  $this->Form->setTemplates([
       //     "textarea" => "<div class='col-8'><textarea class='form-control' name = '{{name}}' {{attrs}}>{{value}}</textarea></div>",
       //     'nestingLabel' => '{{hidden}}<label class="form-check-label" style="font-weight: normal; font-size: 14px;" {{attrs}}>{{text}}</label>',
       //     'radioWrapper' => '<div class="form-check form-check-inline">{{label}}{{input}}</div>',
       //     'radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
       //     'legend' => '<legend style = "font-weight: normal">{{text}}</legend>',
       // ]);
        ?>

        <fieldset>

            <legend><?= __('Nova avaliação') ?></legend>
            <?= $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome]]); ?>
            <br>

            <h3>Desempenho discente no espaço ocupacional</h3>

            <legend>
                <?= __('1) Sobre assiduidade: manteve a frequência, ausentando-se apenas com conhecimento da supervisão de campo e acadêmica, seja por motivo de saúde ou por situações estabelecidas na Lei 11788/2008, entre outras:') ?>
            </legend>
            <?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('2) Sobre pontualidade: cumpre o horário estabelecido no Plano de Estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('3) Sobre compromisso: possui compromisso com as ações e estratégias previstas no Plano de Estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('4) Na relação com usuários(as): compromisso ético-político no atendimento:') ?>
            </legend>
            <?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('5) Na relação com profissionais: integração e articulação à equipe de estágio, cooperação e habilidade para trabalhar em equipe multiprofissional:') ?>
            </legend>
            <?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('6) Sobre criticidade e iniciativa: possui capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo, e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('8) Avaliação do desempenho na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:') ?>
            </legend>
            <?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            <br>

            <legend>
                <?= __('9) O plano de estágio foi elaborado pela supervisão de campo, estudante e com apoio da supervisão acadêmica no início do semestre?') ?>
            </legend>
            <?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <legend>
                <?= __('10) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?') ?>
            </legend>
            <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <legend>
                <?= __('11) O desempenho das atividades desenvolvidas pelo/a discente e o processo de supervisão foram afetados pelas condições de trabalho?') ?>
            </legend>
            <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <h3>Relação interinstitucional</h3>

            <legend>
                <?= __('1) Quanto à integração sala de aula/campo de estágio, houve alguma interlocução entre discente, docente e supervisão de campo?') ?>
            </legend>
            <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <legend>
                <?= __('2) Quanto à integração Coordenação de estágio/campo de estágio: houve algum tipo de interlocução?') ?>
            </legend>
            <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>            

            <legend>
                <?= __('3) Você tomou conhecimento do conteúdo da Disciplina de OTP?') ?>
            </legend>
            <?= $this->Form->input('avaliacao14', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <legend>
                <?= __('4) Você participou de alguma atividade promovida e/ou convocada por docente ou Coordenação de Estágio (reuniões, Fórum Local de Estágio, cursos, eventos, entre outros)?') ?>
            </legend>
            <?= $this->Form->input('avaliacao15', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <h4>Caso positivo, por favor, informe qual:</h4>
            <?= $this->Form->input('avaliacao16', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>
            <br>

            <legend>
                <?= __('5) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?') ?>
            </legend>
            <?= $this->Form->input('avaliacao17', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            <br>

            <h4>Caso positivo, por favor, informe qual:</h4>
            <?= $this->Form->input('avaliacao18', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>
            <br>

            <h4>6) De modo geral, como avalia a experiência do estágio neste semestre? Será possível a continuidade no próximo? Aproveite este espaço para deixar suas críticas, sugestões e/ou observações:</h4>
            <?= $this->Form->input('avaliacao19', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>
            <br>

            <h4>Outras observações</h4>
            <?= $this->Form->input('observacoes', ['type' => 'textarea', 'label' => 'Outras observações', 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>
            <br>

        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>