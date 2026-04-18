<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */

declare(strict_types=1);

?>

<div style="text-align: center; margin-bottom: 20px;">
    <h1>Estudantes estagiários professor(a): <?= $professor->nome; ?></h1>
    <?php if ($periodo): ?>
        <h2>Período: <?= $periodo; ?></h2>
    <?php endif; ?>
</div>

<div style="margin: 20px;">
    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Aluno</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">DRE</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Instituição</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Supervisor</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Período</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Nível</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Nota</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">CH</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Folha de atividades</th>
                <th style="border: 1px solid #dee2e6; padding: 8px; text-align: left;">Avaliação discente</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <td style="border: 1px solid #dee2e6; padding: 8px;"><?= $estagiario->aluno->nome ?></td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;"><?= $estagiario->registro ?></td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;">
                        <?= $estagiario->instituicao->instituicao ?? 'N/A' ?>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;">
                        <?= $estagiario->supervisor->nome ?? 'N/A' ?>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;"><?= $estagiario->periodo ?></td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;"><?= $estagiario->nivel ?></td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;"><?= $this->Number->format($estagiario->nota, ['precision' => 2]) ?></td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;"><?= $this->Number->format($estagiario->ch) ?></td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;">
                        <?= isset($estagiario->folhadeatividades_id) ? 'Sim' : 'Não' ?>
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;">
                        <?= isset($estagiario->avaliacao_id) ? 'Sim' : 'Não' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>