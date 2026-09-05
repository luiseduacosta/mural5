<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */

use Cake\I18n\DateTime;
use Cake\I18n\I18n;

I18n::setLocale('pt-BR');
$hoje = DateTime::now('America/Sao_Paulo', 'pt_BR');

$this->layout = 'default';
$this->assign('title', 'Lista de Inscrições');
$logoUfrj = $this->Url->image('logo_ufrj.png', ['fullBase' => true]);
?>

<h2 style="text-align: center; margin-bottom: 20px;">
    <img src="<?= $logoUfrj ?>" alt="ESS" width="200" height="50" /><br />
    Seleção de estágio para <?= h($muralestagio->instituicao) ?><br />
    <small style="font-size: 14px; font-weight: normal;">Lista de inscrições (Período: <?= h($muralestagio->periodo) ?>)</small>
</h2>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Aluno(a)</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Matrícula</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Email</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Celular</th>
            <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Data de inscrição</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($muralestagio->inscricoes)): ?>
            <?php foreach ($muralestagio->inscricoes as $insc): ?>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;"><?= h($insc->aluno->nome ?? '') ?></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?= h($insc->aluno->registro ?? '') ?></td>
                <td style="border: 1px solid #ddd; padding: 8px;"><?= h($insc->aluno->email ?? '') ?></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?= h($insc->aluno->celular ?? '') ?></td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                    <?= $insc->timestamp ? $insc->timestamp->format('d/m/Y H:i:s') : '' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                    Nenhuma inscrição cadastrada para este mural de estágio.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<p style="text-align: right; margin-top: 30px;">
    Rio de Janeiro, <?= $hoje->i18nFormat("dd ' de ' MMMM ' de ' yyyy") ?>
</p>

<br /><br />

<p style="text-align: center;">
    <strong>Coordenação de Estágio</strong><br />
    ESS / UFRJ
</p>

