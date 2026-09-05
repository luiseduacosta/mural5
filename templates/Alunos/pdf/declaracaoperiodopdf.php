<?php
/**
 * Certificado de Período PDF
 *
 * @var \App\Model\Entity\Aluno $aluno
 * @var int $totalperiodos
 */
use Cake\I18n\DateTime;
use Cake\I18n\I18n;

I18n::setLocale('pt-BR');
$hoje = DateTime::now('America/Sao_Paulo', 'pt_BR');

if (($aluno->TurnoID->turno ?? null) == 'diurno') {
    $duracaocurso = '8';
} elseif (($aluno->TurnoID->turno ?? null) == 'noturno') {
    $duracaocurso = '10';
}

// PdfView already scopes layouts to templates/layout/pdf/, so the name is 'default'
// (the controller sets layout = 'default' in viewBuilder(), and CakePdf prepends 'pdf/').
$this->layout = 'default';
$this->assign('title', 'Declaração de Período');

// ESS logo (horizontal, blue) rasterized as PNG because DomPDF does not render SVG.
$logoPath = dirname(__DIR__, 3) . DS . 'webroot' . DS . 'img' . DS . 'logoess_horizontal-azul.png';
$logoDataUri = '';
if (is_readable($logoPath)) {
    $logoDataUri = 'data:image/png;base64,' . base64_encode((string)file_get_contents($logoPath));
}
?>

<div style="text-align:center;">
    <?php if ($logoDataUri !== '') : ?>
        <img src="<?= $logoDataUri ?>" alt="Escola de Serviço Social" style="width:220px;" />
    <?php endif; ?>
    <p style="margin:18px 0 2px; font-size:14px;">Universidade Federal do Rio de Janeiro</p>
    <p style="margin:0 0 2px; font-size:14px;">Escola de Serviço Social</p>
    <p style="margin:16px 0 0; font-size:15px; font-weight:bold;">Coordenação de Estágio</p>
</div>
<br />
<br />
<p style="text-align:justify; line-height: 2.5;">
    Declaramos que o/a aluno/a <b><?= h($aluno->nome) ?></b> 
    inscrito(a) no CPF sob o nº <?= h($aluno->cpf) ?> 
    e no RG nº <?= h($aluno->identidade) ?> 
    expedido por <?= h($aluno->orgao) ?>, 
    matriculado(a) no Curso de Serviço Social da 
    Universidade Federal do Rio de Janeiro com o número <?= h($aluno->registro) ?>, 
    ingressou em <?= h($aluno->ingresso) ?> no turno <?= ucfirst(h($aluno->TurnoID->turno ?? '')) ?>
    cursando atualmente <?= $totalperiodos ?><sup>o</sup> período.
</p>

<p style="text-align:justify; line-height: 2.5;">
    O turno <?= ucfirst(h($aluno->TurnoID->turno ?? '')) ?> do curso de Serviço Social consta de <?= ($aluno->TurnoID->turno && $aluno->TurnoID->turno == 'diurno') ? '8' : '10' ?> semestres.
</p>
<br />
<br />
<p style="text-align:right">Rio de Janeiro, <?= $hoje->i18nFormat("dd ' de ' MMMM ' de ' yyyy") ?>.</p>

<br style='line-height: 10.0'/>

<table style="margin-left: auto; margin-right: auto;">
        <tr style="text-align:center">
            <td style="text-decoration: overline;">Coordenação de Estágio</td>
        </tr>
        <tr style="text-align:center">
            <td>Escola de Serviço Social</td>
        </tr>
        <tr style="text-align:center">
            <td>Universidade Federal do Rio de Janeiro</td>
        </tr>
</table>
