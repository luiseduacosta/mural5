<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 */
// pr($avaliacao);

if (isset($avaliacao->estagiario->supervisor->nome)) {
    $supervisora = $avaliacao->estagiario->supervisor->nome;
} else {
    $supervisora = "____________________";
}

if (isset($avaliacao->estagiario->supervisor->regiao)) {
    $regiao = $avaliacao->estagiario->supervisor->regiao;
} else {
    $regiao = '__';
}

if (isset($avaliacao->estagiario->supervisor->cress)) {
    $cress = $avaliacao->estagiario->supervisor->cress;
} else {
    $cress = '_____';
}

if (isset($avaliacao->estagiario->professor->nome)) {
    $professora = $avaliacao->estagiario->professor->nome;
} else {
    $professora = '____________________';
}
?>

<style>
    table {
        table-layout: fixed;
        width: 100%;
    }

    th {
        white-space: normal;
        font-weight: normal;
    }

    td {
        text-align: right;
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
                <?php if ($this->getRequest()->getSession()->read('categoria') == 1 || $this->getRequest()->getSession()->read('categoria') == 4): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar avaliação'), ['action' => 'edit', $avaliacao->id], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir avaliação'), ['action' => 'delete', $avaliacao->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $avaliacao->id), 'class' => 'btn btn-danger float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar avaliações'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova avaliação'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <?= $this->Html->link(__('Imprimir avaliação'), ['action' => 'imprimeavaliacaopdf/' . $avaliacao->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h3><?= 'Avaliação da(o) estagiario(a) ' . $avaliacao->estagiario->aluno->nome ?></h3>
        <p><span style="font-size: 100%; text-align: justify; font-weight: normal">Campo de estágio
                <?= $avaliacao->estagiario->instituicao->instituicao ?>. Supervisor(a) <?= $supervisora ?>,
                Cress <?= $cress ?>. Período de estágio <?= $avaliacao->estagiario->periodo ?>. Nível:
                <?= $avaliacao->estagiario->nivel ?>. Supervisão acadêmica: <?= $professora ?></span></p>

        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $avaliacao->id ?></td>
            </tr>
            <tr>
                <th><?= __('Estagiario') ?></th>
                <td><?= $avaliacao->hasValue('estagiario') ? $this->Html->link($avaliacao->estagiario->aluno->nome, ['controller' => 'Estagiarios', 'action' => 'view', $avaliacao->estagiario->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('1) Sobre assiduidade: manteve a frequência, ausentando-se apenas com conhecimento da supervisão de campo e acadêmica, seja por motivo de saúde ou por situações estabelecidas na Lei 11788/2008, entre outras:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao1):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?>
                </td>
            </tr>
            <tr>
                <th><?= __('2) Sobre pontualidade: cumpre o horário estabelecido no Plano de Estágio:') ?></th>
                <td><?php
                switch ($avaliacao->avaliacao2):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('3) Sobre compromisso: possui compromisso com as ações e estratégias previstas no Plano de Estágio:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao3):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('4) Na relação com usuários(as): compromisso ético-político no atendimento:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao4):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('5) Na relação com profissionais: integração e articulação à equipe de estágio, cooperação e habilidade para trabalhar em equipe multiprofissional:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao5):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('6) Sobre criticidade e iniciativa: possui capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao6):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('7) Apreensão do referencial teórico-metodológico, ético-político e investigativo, e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao7):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('8) Avaliação do desempenho na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao8):
                    case 0:
                        echo "Ruim";
                        break;
                    case 1:
                        echo "Regular";
                        break;
                    case 2:
                        echo "Bom";
                        break;
                    case 3:
                        echo "Excelente";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('9) O plano de estágio foi elaborado pela supervisão de campo, estudante e com apoio da supervisão acadêmica no início do semestre?') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao9):
                    case 0:
                        echo "Sim";
                        break;
                    case 1:
                        echo "Não";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('10) As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao10):
                    case 0:
                        echo "Sim";
                        break;
                    case 1:
                        echo "Não";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('11) O desempenho das atividades desenvolvidas pelo/a discente e o processo de supervisão foram afetados pelas condições de trabalho?') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao11):
                    case 0:
                        echo "Sim";
                        break;
                    case 1:
                        echo "Não";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>

            <tr>
                <td colspan=2>Relação interinstitucional</td>
            </tr>

            <tr>
                <th><?= __('1) Quanto à integração sala de aula/campo de estágio, houve alguma interlocução entre discente, docente e supervisão de campo?') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao12):
                    case 0:
                        echo "Sim";
                        break;
                    case 1:
                        echo "Não";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>
            <tr>
                <th><?= __('2) Quanto à integração Coordenação de estágio/campo de estágio: houve algum tipo de interlocução?') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao13):
                    case 0:
                        echo "Sim";
                        break;
                    case 1:
                        echo "Não";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>

            <tr>
                <th><?= __('3) Você tomou conhecimento do conteúdo da Disciplina de OTP?') ?>
                </th>
                <td><?php
                switch ($avaliacao->avaliacao14):
                    case 0:
                        echo "Sim";
                        break;
                    case 1:
                        echo "Não";
                        break;
                    default:
                        echo "Sem avaliação";
                        break;
                endswitch;
                ?></td>
            </tr>

            <tr>
                <th><?= __('4) Você participou de alguma atividade promovida e/ou convocada por docente ou Coordenação de Estágio (reuniões, Fórum Local de Estágio, cursos, eventos, entre outros)?') ?>
                </th>
                <td>
                    <?php
                    switch ($avaliacao->avaliacao15):
                        case 0:
                            echo "Sim";
                            break;
                        case 1:
                            echo "Não";
                            break;
                        default:
                            echo "Sem avaliação";
                            break;
                    endswitch;
                    ?>
                </td>
            </tr>

            <tr>
                <th><?= __('Caso positivo, por favor, informe qual:') ?></th>
                <td><?= h($avaliacao->avaliacao16) ?></td>
            </tr>

            <tr>
                <th>
                    <?= __('5) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?') ?>
                </th>
                <td>
                    <?php
                    switch ($avaliacao->avaliacao17):
                        case 0:
                            echo "Sim";
                            break;
                        case 1:
                            echo "Não";
                            break;
                        default:
                            echo "Sem avaliação";
                            break;
                    endswitch;
                    ?>
                </td>
            </tr>

            <tr>
                <th><?= __('Caso positivo, por favor, informe qual:') ?></th>
                <td><?= h($avaliacao->avaliacao18) ?></td>
            </tr>

            <tr>
                <th><?= __('De modo geral, como avalia a experiência do estágio neste semestre? Será possível a continuidade no próximo? Aproveite este espaço para deixar suas críticas, sugestões e/ou observações') ?>
                </th>
                <td><?= h($avaliacao->avaliacao19) ?></td>
            </tr>

            <tr>
                <th><?= __('Sugestões e observações:') ?></th>
                <td><?= h($avaliacao->observacoes) ?></td>
            </tr>
        </table>
    </div>
</div>