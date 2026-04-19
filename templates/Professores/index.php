<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
?>

<div class="container">

    <?php if (isset($categoria) && $categoria == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Nova professora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
                    </li>
                </ul>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    </ul>
</nav>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                    <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                    <th><?= $this->Paginator->sort('codigo_telefone', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('codigo_celular', 'DDD') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                    <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                    <th><?= $this->Paginator->sort('atualizacaolattes') ?></th>
                    <th><?= $this->Paginator->sort('dataingresso', 'Data de ingresso') ?></th>
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
                        <td><?= h($professor->codigo_telefone) ?></td>
                        <td><?= h($professor->telefone) ?></td>
                        <td><?= h($professor->codigo_celular) ?></td>
                        <td><?= h($professor->celular) ?></td>
                        <td><?= h($professor->email) ?></td>
                        <td><?= h($professor->curriculolattes) ?></td>
                        <td><?= h($professor->atualizacaolattes) ?></td>
                        <td><?= $professor->dataingresso ? $professor->dataingresso->format('d-m-Y') : '' ?></td>
                        <td><?= h($professor->departamento) ?></td>
                        <td><?= $professor->dataegresso ? $professor->dataegresso->format('d-m-Y') : '' ?></td>
                        <td><?= h($professor->motivoegresso) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $professor->id]) ?>
                            <?php if (isset($categoria) && $categoria == 1): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $professor->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $professor->id)]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="tab-content">
        <div id="professor1" class="tab-pane container active show">
            <h3><?= __('Dados funcionais') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                        <th><?= $this->Paginator->sort('departamento', 'Departamento') ?></th>
                        <th><?= $this->Paginator->sort('dataingresso', 'Data de ingresso') ?></th>
                        <th><?= $this->Paginator->sort('dataegresso', 'Data de egresso') ?></th>
                        <th><?= $this->Paginator->sort('motivoegresso', 'Motivo de egresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->siape ?></td>
                            <td><?= $professor->departamento ?></td>
                            <td><?= $professor->dataingresso ? $professor->dataingresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= $professor->dataegresso ? $professor->dataegresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->motivoegresso) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor2" class="tab-pane container fade">
            <h3><?= __('Dados pessoais') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor3" class="tab-pane container fade">
            <h3><?= __('Dados endereço') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->endereco) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor4" class="tab-pane container fade">
            <h3><?= __('Comunicação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('codigo_telefone', 'Telefone') ?></th>
                        <th><?= $this->Paginator->sort('telefone') ?></th>
                        <th><?= $this->Paginator->sort('codigo_celular', 'Celular') ?></th>
                        <th><?= $this->Paginator->sort('celular') ?></th>
                        <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->codigo_telefone) ?></td>
                            <td><?= h($professor->telefone) ?></td>
                            <td><?= h($professor->codigo_celular) ?></td>
                            <td><?= h($professor->celular) ?></td>
                            <td><?= $professor->email ? $this->Html->link($professor->email, 'mailto:' . $professor->email) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor5" class="tab-pane container fade">
            <h3><?= __('Currículo') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                        <th><?= $this->Paginator->sort('atualizacaolattes', 'Última atualização') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->curriculolattes ? $this->Html->link($professor->curriculolattes, $professor->curriculolattes) : '' ?>
                            </td>
                            <td><?= $professor->atualizacaolattes ? $professor->atualizacaolattes->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor6" class="tab-pane container fade">
            <h3><?= __('Graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor7" class="tab-pane container fade">
            <h3><?= __('Pós-graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor8" class="tab-pane container fade">
            <h3><?= __('Outras informações') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->observacoes) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->element('templates') ?>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.')) ?>
            </p>
        </div>
    </div>
</div>