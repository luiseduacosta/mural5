<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 */
// pr($estudante);
?>
<?= $this->element('templates') ?>
<div class="container">

    <?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $estudante->id], ['class' => 'btn btn-secondary float-end']) ?>
    <?php if ($this->getRequest()->getAttribute('identity')->get('categoria_id') == 1): ?>
        <?= $this->Html->link(__('Listar Estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $estudante->id], ['confirm' => __('Tem certeza que quer excluir este registro # {0}?', $estudante->id), 'class' => 'btn btn-danger float-end']) ?>
    <?php endif; ?>

    <ul class="nav nav-tabs id=" myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" id="estudante-tab" href="#estudante"
                data-target="#estudante" role="tab" aria-controls="estudante" aria-selected="true">Dados do
                estudante</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="inscricoes-tab" href="#inscricoes" data-target="#inscricoes"
                role="tab" aria-controls="inscricoes" aria-selected="false">Inscrições para estágio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="estagios-tab" href="#estagios" data-target="#estagios"
                role="tab" aria-controls="estagios" aria-selected="true">Estágios cursados</a>
        </li>
    </ul>

    <div class="tab-content" id="meuTabContent">

        <div id="estudante" class="tab-pane fade show active" role="tabpanel" aria-labelledby="estudante-tab">
            <h3><?= h($estudante->nome) ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $estudante->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Registro') ?></th>
                    <td><?= $estudante->registro ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($estudante->nome) ?></td>
                </tr>

                <tr>
                    <th><?= __('Nome social') ?></th>
                    <td><?= h($estudante->nomesocial) ?></td>
                </tr>

                <tr>
                    <th><?= __('Ingresso') ?></th>
                    <td><?= h($estudante->ingresso) ?></td>
                </tr>

                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= h($estudante->turno) ?></td>
                </tr>

                <tr>
                    <th><?= __('Data de nascimento') ?></th>
                    <td><?= $estudante->nascimento ? date('d-m-Y', strtotime($estudante->nascimento)) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('CPF') ?></th>
                    <td><?= h($estudante->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Carteira de identidade') ?></th>
                    <td><?= h($estudante->identidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Orgão emissor') ?></th>
                    <td><?= h($estudante->orgao) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($estudante->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('DDD') ?></th>
                    <td><?= $estudante->codigo_telefone ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($estudante->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('DDD') ?></th>
                    <td><?= $estudante->codigo_celular ?></td>
                </tr>
                <tr>
                    <th><?= __('Celular') ?></th>
                    <td><?= h($estudante->celular) ?></td>
                </tr>
                <tr>
                    <th><?= __('CEP') ?></th>
                    <td><?= h($estudante->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço') ?></th>
                    <td><?= h($estudante->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($estudante->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($estudante->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td><?= h($estudante->observacoes) ?></td>
                </tr>
            </table>
        </div>

        <div id="inscricoes" class="tab-pane" role="tabpanel" aria-labelledby="inscricoes-tab">
            <h4><?= __('Inscrições para seleção de estágio') ?></h4>
            <?php if (!empty($estudante->muralinscricoes)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Mural de estágio') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Período') ?></th>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <th><?= __('Timestamp') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == 2): ?>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($estudante->muralinscricoes as $muralinscricoes): ?>
                            <tr>
                                <td><?= h($muralinscricoes->id) ?></td>
                                <td><?= h($muralinscricoes->registro) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= $muralinscricoes->hasValue('muralestagio') ? $this->Html->link($muralinscricoes->muralestagio->instituicao, ['controller' => 'muralestagios', 'action' => 'view', $muralinscricoes->muralestagio->id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $muralinscricoes->hasValue('muralestagio') ? $muralinscricoes->muralestagio->instituicao : '' ?>
                                    </td>
                                <?php endif; ?>
                                <td><?= date('d-m-Y', strtotime(h($muralinscricoes->data))) ?></td>
                                <td><?= h($muralinscricoes->periodo) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= h($muralinscricoes->timestamp) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricoes->id)]) ?>
                                    </td>
                                <?php elseif ($this->getRequest()->getAttribute('identity')['categoria_id'] == 2): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $muralinscricoes->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div id="estagios" class="tab-pane" role="tabpanel" aria-labelledby="estagios-tab">
            <h4><?= __('Estágios cursados') ?></h4>
            <?php if (!empty($estudante->estagiarios)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Instituição de estágio') ?></th>
                            <th><?= __('Supervisor(a)') ?></th>
                            <th><?= __('Professor(a)') ?></th>
                            <th><?= __('Nota') ?></th>
                            <th><?= __('CH') ?></th>
                            <th><?= __('Observações') ?></th>
                            <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                <th class="actions"><?= __('Actions') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($estudante->estagiarios as $estagiarios): ?>
                            <tr>
                                <?php // pr($estagiarios); ?>
                                <td><?= h($estagiarios->id) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= $estagiarios->hasValue('estudante') ? $this->Html->link(h($estagiarios->estudante->nome), ['controller' => 'estudantes', 'action' => 'view', $estagiarios->estudante_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('estudante') ? $estagiarios->estudante->nome : '' ?></td>
                                <?php endif; ?>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->periodo) ?></td>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= $estagiarios->hasValue('instituicaoestagio') ? $this->Html->link($estagiarios->instituicaoestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $estagiarios->instituicaoestagio_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('instituicaoestagio') ? $estagiarios->instituicaoestagio->instituicao : '' ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                <?php endif; ?>

                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td><?= $estagiarios->hasValue('docente') ? $this->Html->link($estagiarios->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $estagiarios->docente->id]) : 'Sem dados' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasValue('docente') ? $estagiarios->docente->nome : 'Sem informação' ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($estagiarios->nota): ?>
                                    <td><?= $this->Number->format($estagiarios->nota, ['places' => 2]) ?></td>
                                <?php else: ?>
                                    <td>Sem nota</td>
                                <?php endif; ?>

                                <td><?= h($estagiarios->ch) ?></td>
                                <td><?= h($estagiarios->observacoes) ?></td>
                                <?php if ($this->getRequest()->getAttribute('identity')['categoria_id'] == 1): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estagiarios->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php else: ?>
                <p>Sem estágio</p>
            <?php endif; ?>
        </div>
    </div>
</div>