<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
?>
<?php $categoria = $this->getRequest()->getAttribute('identity')->get('categoria'); ?>
<?= $this->element('menu_mural') ?>

<div class="container">

    <?php if (isset($categoria) && $categoria == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
                    aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
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
                        <td><?= $professor->datanascimento ? $professor->datanascimento->format('d-m-Y') : '' ?>
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
                        <td><?= $professor->dataingresso ? $professor->dataingresso->format('d-m-Y') : '' ?></td>
                        <td><?= h($professor->formaingresso) ?></td>
                        <td><?= h($professor->tipocargo) ?></td>
                        <td><?= h($professor->categoria) ?></td>
                        <td><?= h($professor->regimetrabalho) ?></td>
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
                        <th><?= $this->Paginator->sort('formaingresso', 'Forma de ingresso') ?></th>
                        <th><?= $this->Paginator->sort('tipocargo', 'Tipo de cargo') ?></th>
                        <th><?= $this->Paginator->sort('categoria', 'Categoria') ?></th>
                        <th><?= $this->Paginator->sort('regimetrabalho', 'Regime de trabalho') ?></th>
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
                            <td><?= h($professor->formaingresso) ?></td>
                            <td><?= h($professor->tipocargo) ?></td>
                            <td><?= h($professor->categoria) ?></td>
                            <td><?= h($professor->regimetrabalho) ?></td>
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
                        <th><?= $this->Paginator->sort('rg', 'RG') ?></th>
                        <th><?= $this->Paginator->sort('orgaoexpedidor', 'Órgão expedidor') ?></th>
                        <th><?= $this->Paginator->sort('sexo', 'Sexo') ?></th>
                        <th><?= $this->Paginator->sort('datanascimento', 'Data de nascimento') ?></th>
                        <th><?= $this->Paginator->sort('localnascimento', 'Local de nascimento') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                            <td><?= h($professor->rg) ?></td>
                            <td><?= h($professor->orgaoexpedidor) ?></td>
                            <td><?php
                            if ($professor->sexo == '0') {
                                echo 'Feminino';
                            } elseif ($professor->sexo == '1') {
                                echo 'Masculino';
                            } elseif ($professor->sexo == '2') {
                                echo 'Não informado';
                            }
                            ?></td>
                            <td><?= $professor->datanascimento ? $professor->datanascimento->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->localnascimento) ?></td>
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
                        <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                        <th><?= $this->Paginator->sort('bairro', 'Bairro') ?></th>
                        <th><?= $this->Paginator->sort('cidade', 'Cidade') ?></th>
                        <th><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                        <th><?= $this->Paginator->sort('cep', 'CEP') ?></th>
                        <th><?= $this->Paginator->sort('pais', 'País') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->endereco) ?></td>
                            <td><?= h($professor->bairro) ?></td>
                            <td><?= h($professor->cidade) ?></td>
                            <td><?= h($professor->estado) ?></td>
                            <td><?= h($professor->cep) ?></td>
                            <td><?= h($professor->pais) ?></td>
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
                        <th><?= $this->Paginator->sort('ddd_telefone', 'Telefone') ?></th>
                        <th><?= $this->Paginator->sort('telefone') ?></th>
                        <th><?= $this->Paginator->sort('ddd_celular', 'Celular') ?></th>
                        <th><?= $this->Paginator->sort('celular') ?></th>
                        <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                        <th><?= $this->Paginator->sort('homepage', 'Homepage') ?></th>
                        <th><?= $this->Paginator->sort('redesocial', 'Rede social') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->ddd_telefone) ?></td>
                            <td><?= h($professor->telefone) ?></td>
                            <td><?= h($professor->ddd_celular) ?></td>
                            <td><?= h($professor->celular) ?></td>
                            <td><?= $professor->email ? $this->Html->link($professor->email, 'mailto:' . $professor->email) : '' ?>
                            </td>
                            <td><?= $professor->hasValue('homepage') ? $this->Html->link($professor->homepage, $professor->homepage) : '' ?>
                            </td>
                            <td><?= $professor->hasValue('redesocial') ? $this->Html->link($professor->redesocial, $professor->redesocial) : '' ?>
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
                        <th><?= $this->Paginator->sort('curriculosigma', 'Sigma') ?></th>
                        <th><?= $this->Paginator->sort('pesquisadordgp', 'DGP') ?></th>
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
                            <td><?= $professor->curriculosigma ? $this->Html->link($professor->curriculosigma, $professor->curriculosigma) : '' ?>
                            </td>
                            <td><?= $professor->pesquisadordgp ? $this->Html->link($professor->pesquisadordgp, $professor->pesquisadordgp) : '' ?>
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
                        <th><?= $this->Paginator->sort('formacaoprofissional', 'Formação') ?></th>
                        <th><?= $this->Paginator->sort('graduacaoarea', 'Área de graduação') ?></th>
                        <th><?= $this->Paginator->sort('universidadedegraduacao', 'Universidade de graduação') ?></th>
                        <th><?= $this->Paginator->sort('anoformacao', 'Ano de formação') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->formacaoprofissional) ?></td>
                            <td><?= h($professor->universidadedegraduacao) ?></td>
                            <td><?= h($professor->anoformacao) ?></td>
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
                        <th><?= $this->Paginator->sort('mestradoarea', 'Área de mestrado') ?></th>
                        <th><?= $this->Paginator->sort('mestradouniversidade', 'Universidade do mestrado') ?></th>
                        <th><?= $this->Paginator->sort('mestradoanoconclusao', 'Ano de conclusão do mestrado') ?></th>
                        <th><?= $this->Paginator->sort('doutoradoarea', 'Área de doutorado') ?></th>
                        <th><?= $this->Paginator->sort('doutoradouniversidade', 'Universidade de doutorado') ?></th>
                        <th><?= $this->Paginator->sort('doutoradoanoconclusao', 'Ano de conclusão do doutorado') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->mestradoarea) ?></td>
                            <td><?= h($professor->mestradouniversidade) ?></td>
                            <td><?= h($professor->mestradoanoconclusao) ?></td>
                            <td><?= h($professor->doutoradoarea) ?></td>
                            <td><?= h($professor->doutoradouniversidade) ?></td>
                            <td><?= h($professor->doutoradoanoconclusao) ?></td>
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