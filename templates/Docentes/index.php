<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $docentes
 */
?>
<div class="container">
    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                    <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                    <th><?= $this->Paginator->sort('datanascimento', 'Nascimento') ?></th>
                    <th><?= $this->Paginator->sort('localnascimento', 'Local') ?></th>
                    <th><?= $this->Paginator->sort('sexo') ?></th>
                    <th><?= $this->Paginator->sort('ddd_telefone', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('ddd_celular', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                    <th><?= $this->Paginator->sort('homepage') ?></th>
                    <th><?= $this->Paginator->sort('redesocial') ?></th>
                    <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                    <th><?= $this->Paginator->sort('atualizacaolattes') ?></th>
                    <th><?= $this->Paginator->sort('curriculosigma') ?></th>
                    <th><?= $this->Paginator->sort('pesquisadordgp') ?></th>
                    <th><?= $this->Paginator->sort('formacaoprofissional', 'Formação') ?></th>
                    <th><?= $this->Paginator->sort('universidadedegraduacao') ?></th>
                    <th><?= $this->Paginator->sort('anoformacao', 'Ano') ?></th>
                    <th><?= $this->Paginator->sort('mestradoarea', 'Área') ?></th>
                    <th><?= $this->Paginator->sort('mestradouniversidade') ?></th>
                    <th><?= $this->Paginator->sort('mestradoanoconclusao') ?></th>
                    <th><?= $this->Paginator->sort('doutoradoarea') ?></th>
                    <th><?= $this->Paginator->sort('doutoradouniversidade') ?></th>
                    <th><?= $this->Paginator->sort('doutoradoanoconclusao') ?></th>
                    <th><?= $this->Paginator->sort('dataingresso') ?></th>
                    <th><?= $this->Paginator->sort('formaingresso') ?></th>
                    <th><?= $this->Paginator->sort('tipocargo') ?></th>
                    <th><?= $this->Paginator->sort('categoria') ?></th>
                    <th><?= $this->Paginator->sort('regimetrabalho') ?></th>
                    <th><?= $this->Paginator->sort('departamento') ?></th>
                    <th><?= $this->Paginator->sort('dataegresso') ?></th>
                    <th><?= $this->Paginator->sort('motivoegresso') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docentes as $docente): ?>
                    <tr>
                        <td><?= $docente->id ?></td>
                        <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentes', 'action' => 'view', $docente->id]) ?>
                        </td>
                        <td><?= h($docente->cpf) ?></td>
                        <td><?= $docente->siape ?></td>
                        <td><?= $docente->datanascimento ? date('d-m-Y', strtotime(h($docente->datanascimento))) : '' ?>
                        </td>
                        <td><?= h($docente->localnascimento) ?></td>
                        <td><?= h($docente->sexo) ?></td>
                        <td><?= h($docente->ddd_telefone) ?></td>
                        <td><?= h($docente->telefone) ?></td>
                        <td><?= h($docente->ddd_celular) ?></td>
                        <td><?= h($docente->celular) ?></td>
                        <td><?= h($docente->email) ?></td>
                        <td><?= h($docente->homepage) ?></td>
                        <td><?= h($docente->redesocial) ?></td>
                        <td><?= h($docente->curriculolattes) ?></td>
                        <td><?= h($docente->atualizacaolattes) ?></td>
                        <td><?= h($docente->curriculosigma) ?></td>
                        <td><?= h($docente->pesquisadordgp) ?></td>
                        <td><?= h($docente->formacaoprofissional) ?></td>
                        <td><?= h($docente->universidadedegraduacao) ?></td>
                        <td><?= $docente->anoformacao ?></td>
                        <td><?= h($docente->mestradoarea) ?></td>
                        <td><?= h($docente->mestradouniversidade) ?></td>
                        <td><?= $docente->mestradoanoconclusao ?></td>
                        <td><?= h($docente->doutoradoarea) ?></td>
                        <td><?= h($docente->doutoradouniversidade) ?></td>
                        <td><?= $docente->doutoradoanoconclusao ?></td>
                        <td><?= $docente->dataingresso ? date('d-m-Y', strtotime(h($docente->dataingresso))) : '' ?></td>
                        <td><?= h($docente->formaingresso) ?></td>
                        <td><?= h($docente->tipocargo) ?></td>
                        <td><?= h($docente->categoria) ?></td>
                        <td><?= h($docente->regimetrabalho) ?></td>
                        <td><?= h($docente->departamento) ?></td>
                        <td><?= $docente->dataegresso ? date('d-m-Y', strtotime(h($docente->dataegresso))) : '' ?></td>
                        <td><?= h($docente->motivoegresso) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $docente->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $docente->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $docente->id], ['confirm' => __('Are you sure you want to delete # {0}?', $docente->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $this->element('templates'); ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->element('paginator') ?>
            </ul>
        </div>
    </div>
    <?= $this->element('paginator_count') ?>
</div>