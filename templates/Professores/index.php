<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
?>

<div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                    aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <?php if($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova professora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

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
                    <th class="actions"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($professores as $professor): ?>
                    <tr>
                        <td><?= $professor->id ?></td>
                        <td><?= $this->Html->link(h($professor->nome), ['controller' => 'professores', 'action' => 'view', $professor->id]) ?>
                        </td>
                        <td><?= h($professor->cpf) ?></td>
                        <td><?= $professor->siape ?></td>
                        <td><?= $professor->datanascimento ? date('d-m-Y', strtotime(h($professor->datanascimento))) : '' ?>
                        </td>
                        <td><?= h($professor->localnascimento) ?></td>
                        <td><?= h($professor->sexo) ?></td>
                        <td><?= h($professor->ddd_telefone) ?></td>
                        <td><?= h($professor->telefone) ?></td>
                        <td><?= h($professor->ddd_celular) ?></td>
                        <td><?= h($professor->celular) ?></td>
                        <td><?= h($professor->email) ?></td>
                        <td><?= h($professor->homepage) ?></td>
                        <td><?= h($professor->redesocial) ?></td>
                        <td><?= h($professor->curriculolattes) ?></td>
                        <td><?= h($professor->atualizacaolattes) ?></td>
                        <td><?= h($professor->curriculosigma) ?></td>
                        <td><?= h($professor->pesquisadordgp) ?></td>
                        <td><?= h($professor->formacaoprofissional) ?></td>
                        <td><?= h($professor->universidadedegraduacao) ?></td>
                        <td><?= $professor->anoformacao ?></td>
                        <td><?= h($professor->mestradoarea) ?></td>
                        <td><?= h($professor->mestradouniversidade) ?></td>
                        <td><?= $professor->mestradoanoconclusao ?></td>
                        <td><?= h($professor->doutoradoarea) ?></td>
                        <td><?= h($professor->doutoradouniversidade) ?></td>
                        <td><?= $professor->doutoradoanoconclusao ?></td>
                        <td><?= $professor->dataingresso ? date('d-m-Y', strtotime(h($professor->dataingresso))) : '' ?></td>
                        <td><?= h($professor->formaingresso) ?></td>
                        <td><?= h($professor->tipocargo) ?></td>
                        <td><?= h($professor->categoria) ?></td>
                        <td><?= h($professor->regimetrabalho) ?></td>
                        <td><?= h($professor->departamento) ?></td>
                        <td><?= $professor->dataegresso ? date('d-m-Y', strtotime(h($professor->dataegresso))) : '' ?></td>
                        <td><?= h($professor->motivoegresso) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                            <?php if($user->isAdmin()): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                            <?php endif; ?>
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