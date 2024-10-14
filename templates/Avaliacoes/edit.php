<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 * @var \Cake\Collection\CollectionInterface|string[] $avaliacoes
 */
// pr($estagiario);
// die();
?>
<?php
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());

$supervisora = isset($estagiario->supervisor->nome);
if ($supervisora) {
    $supervisora = $estagiario->supervisor->nome;
} else {
    $supervisora = "____________________";
}

$regiao = isset($estagiario->supervisor->regiao);
if ($regiao) {
    $regiao = $estagiario->supervisor->regiao;
} else {
    $regiao = '__';
}

$cress = isset($estagiario->supervisor->cress);
if ($cress) {
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
                    <?= $this->Html->link(__('Listar avaliações'), ['action' => 'index/' . $estagiario->id . '/' . $estagiario->registro], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <h1>Formulário de avalição da(a) discente <?= $estagiario->aluno->nome ?></h1>
    <div class="container">
        <?= $this->Form->create($avaliacao) ?>
        <?php
        $this->Form->setTemplates([
            "textarea" => "<div class='col-8'><textarea class='form-control' name = '{{name}}' {{attrs}}>{{value}}</textarea></div>",
            'nestingLabel' => '{{hidden}}<label class="form-check-label" style="font-weight: normal; font-size: 14px;" {{attrs}}>{{text}}</label>',
            'radioWrapper' => '<div class="form-check form-check-inline">{{label}}{{input}}</div>',
            'radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
            'legend' => '<legend style = "font-weight: normal">{{text}}</legend>',
        ]);
        ?>

        <fieldset>

            <legend><?= __('Nova avaliação') ?></legend>
            <?= $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome]]); ?>

            <legend>
                <?= __('1) ASSIDUIDADE: Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:') ?>
            </legend>
            <?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= __('2) PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= __('3) COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= ('4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):') ?>
            </legend>
            <?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= ('5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:') ?>
            </legend>
            <?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= ('6) CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= ('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:') ?>
            </legend>
            <?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= ('8)  Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:') ?>
            </legend>
            <?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend>
                <?= ('9)  As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?') ?>
            </legend>
            <?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <p>Fundamente se achar necessário: </p>
            <?= $this->Form->input('avaliacao9-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>

            <legend>
                <?= ('10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto?') ?>
            </legend>
            <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <p>Justifique a resposta se achar necessário:</p>
            <?= $this->Form->input('avaliacao10-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend>
                <?= ('11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?') ?>
            </legend>
            <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <p>Como você avalia esta interação? (Responda se achar necessário)</p>
            <?= $this->Form->input('avaliacao11-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend>
                <?= ('12) Você recebeu e acompanhou o programa da Disciplina OTP?') ?>
            </legend>
            <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <p>Sugestões ao que foi desenvolvido?</p>
            <?= $this->Form->input('avaliacao12-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend>
                <?= ('13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?') ?>
            </legend>
            <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <p>Se sim, quais?</p>
            <?= $this->Form->input('avaliacao13-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <p>14) Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do
                estágio na modalidade remota no próximo semestre?') </p>
            <?= $this->Form->input('avaliacao14', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <p>Sugestões e observações:</p>
            <?= $this->Form->input('observacoes', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>