<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Muralestagio'), ['action' => 'edit', $muralestagio->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Muralestagio'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralestagio->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Muralestagios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Muralestagio'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="muralestagios view content">
            <h3><?= h($muralestagio->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Instituicaoestagio') ?></th>
                    <td><?= $muralestagio->has('instituicaoestagio') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $muralestagio->instituicaoestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= h($muralestagio->instituicao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Convenio') ?></th>
                    <td><?= h($muralestagio->convenio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Beneficios') ?></th>
                    <td><?= h($muralestagio->beneficios) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final De Semana') ?></th>
                    <td><?= h($muralestagio->final_de_semana) ?></td>
                </tr>
                <tr>
                    <th><?= __('Requisitos') ?></th>
                    <td><?= h($muralestagio->requisitos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Areaestagio') ?></th>
                    <td><?= $muralestagio->has('areaestagio') ? $this->Html->link($muralestagio->areaestagio->id, ['controller' => 'Areaestagios', 'action' => 'view', $muralestagio->areaestagio->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Horario') ?></th>
                    <td><?= h($muralestagio->horario) ?></td>
                </tr>
                <tr>
                    <th><?= __('Docente') ?></th>
                    <td><?= $muralestagio->has('docente') ? $this->Html->link($muralestagio->docente->id, ['controller' => 'Docentes', 'action' => 'view', $muralestagio->docente->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('HorarioSelecao') ?></th>
                    <td><?= h($muralestagio->horarioSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('LocalSelecao') ?></th>
                    <td><?= h($muralestagio->localSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('FormaSelecao') ?></th>
                    <td><?= h($muralestagio->formaSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contato') ?></th>
                    <td><?= h($muralestagio->contato) ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($muralestagio->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('LocalInscricao') ?></th>
                    <td><?= h($muralestagio->localInscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($muralestagio->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($muralestagio->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vagas') ?></th>
                    <td><?= $this->Number->format($muralestagio->vagas) ?></td>
                </tr>
                <tr>
                    <th><?= __('CargaHoraria') ?></th>
                    <td><?= $this->Number->format($muralestagio->cargaHoraria) ?></td>
                </tr>
                <tr>
                    <th><?= __('DataSelecao') ?></th>
                    <td><?= h($muralestagio->dataSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('DataInscricao') ?></th>
                    <td><?= h($muralestagio->dataInscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Datafax') ?></th>
                    <td><?= h($muralestagio->datafax) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Outras') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($muralestagio->outras)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Inscricoes para o Mural de Estágios') ?></h4>
                <?php if (!empty($muralestagio->muralinscricoes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Estudante Id') ?></th>
                            <th><?= __('Muralestagio Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Timestamp') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($muralestagio->muralinscricoes as $muralinscricoes) : ?>
                        <tr>
                            <?php // pr($muralinscricoes) ?>
                            <td><?= h($muralinscricoes->id) ?></td>
                            <td><?= h($muralinscricoes->id_aluno) ?></td>
                            <td><?= $this->Html->link($muralinscricoes->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $muralinscricoes->alunonovo_id]); ?></td>
                            <td><?= h($muralinscricoes->id_instituicao) ?></td>
                            <td><?= h($muralinscricoes->data) ?></td>
                            <td><?= h($muralinscricoes->periodo) ?></td>
                            <td><?= h($muralinscricoes->timestamp) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricoes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
