<?php
$usuario = $this->getRequest()->getAttribute('identity');
// pr($usuario);
// die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 */
// pr($muralestagio);
// die();
?>
<div class="container">

    <?php if (isset($usuario) && $usuario->categoria_id == '1'): ?>
        <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $muralestagio->id), 'class' => 'btn btn-danger float-end']) ?>
    <?php endif; ?>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#instituicao" role="tab"
                    aria-controls="Instituição" aria-selected="true">Instituição</a>
            </li>
            <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#inscricoes" role="tab"
                        aria-controls="Estudantes inscritos" aria-selected="false">Estudantes inscritos</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="row">
        <div class="tab-content">

            <div id="instituicao" class="tab-pane active show">
                <h3><?= h($muralestagio->instituicao) ?></h3>

                <table class='table table-striped table-hover table-responsive'>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $muralestagio->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Instituição') ?></th>
                        <?php if ($this->getRequest()->getSession()->read('categoria') == 1): ?>
                            <td><?= $muralestagio->has('instituicaoestagio') ? $this->Html->link($muralestagio->instituicao, ['controller' => 'Instituicaoestagios', 'action' => 'view', $muralestagio->instituicaoestagio_id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td><?= $muralestagio->has('instituicaoestagio') ? $muralestagio->instituicao : '' ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Convênio com UFRJ') ?></th>
                        <td><?= (h($muralestagio->convenio) == 0) ? 'Não' : 'Sim' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Benefícios') ?></th>
                        <td><?= h($muralestagio->beneficios) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Final de Semana') ?></th>
                        <td><?php
                        switch ($muralestagio->final_de_semana) {
                            case 0:
                                echo "Não";
                                break;
                            case 1;
                                echo "Sim";
                                break;
                            case 2:
                                echo "Parcialmente";
                                break;
                            default;
                                echo "Não";
                                break;
                        }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Requisitos') ?></th>
                        <td><?= $muralestagio->requisitos ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Turma de estágio') ?></th>
                        <?php if (isset($muralestagio->areaestagio->area)): ?>
                            <td><?= $muralestagio->has('areaestagio') ? $this->Html->link($muralestagio->areaestagio->area, ['controller' => 'Areaestagios', 'action' => 'view', $muralestagio->areaestagio->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Horário da OTP') ?></th>
                        <td><?php
                        switch ($muralestagio->horario) {
                            case 'D':
                                echo "Diurno";
                                break;
                            case 'N':
                                echo "Noturno";
                                break;
                            case 'I':
                                echo 'Indeterminado';
                                break;
                            default:
                                echo 'Indeterminado';
                                break;
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Professor') ?></th>
                        <?php if (!empty($muralestagio->professor->nome)): ?>
                            <td><?= $muralestagio->has('professor') ? $this->Html->link($muralestagio->professor->nome, ['controller' => 'Professores', 'action' => 'view', $muralestagio->professor->id]) : '' ?>
                            </td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __('Horario da seleção') ?></th>
                        <td><?= h($muralestagio->horarioSelecao) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Local da seleção') ?></th>
                        <td><?= h($muralestagio->localSelecao) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Forma de seleção') ?></th>
                        <td><?php
                        switch ($muralestagio->formaSelecao) {
                            case '0':
                                echo 'Entrevista';
                                break;
                            case '1':
                                echo 'CR';
                                break;
                            case '2':
                                echo 'Prova';
                                break;
                            case '3':
                                echo 'Outras';
                                break;
                            default:
                                echo 'Outras: ver nas observações';
                                break;
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Contato') ?></th>
                        <td><?= h($muralestagio->contato) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('E-mail') ?></th>
                        <td><?= h($muralestagio->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Período') ?></th>
                        <td><?= h($muralestagio->periodo) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Local da inscrição') ?></th>
                        <td><?php
                        switch ($muralestagio->localInscricao) {
                            case '0':
                                echo 'Somente no mural da Coordenação de Estágio/ESS';
                                break;
                            case '1':
                                echo 'Diretamente na Instituição e no mural da Coordenação de Estágio/ESS';
                                break;
                            default:
                                echo 'Somente no mural da Coordenação de Estágio/ESS';
                                break;
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Vagas') ?></th>
                        <td><?= $muralestagio->vagas ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Carga horária') ?></th>
                        <td><?= $this->Number->format($muralestagio->cargaHoraria) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data da seleção') ?></th>
                        <td><?= $muralestagio->dataSelecao ? date('d-m-Y', strtotime($muralestagio->dataSelecao)) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Data de encerramento da inscrição') ?></th>
                        <td><?= $muralestagio->dataInscricao ? date('d-m-Y', strtotime($muralestagio->dataInscricao)) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Data fax') ?></th>
                        <td><?= $muralestagio->datafax ? date('d-m-Y', strtotime(h($muralestagio->datafax))) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <div class="text">
                            <th><?= __('Outras informações') ?></th>
                            <td>
                                <blockquote>
                                    <?= $this->Text->autoParagraph($muralestagio->outras); ?>
                                </blockquote>
                            </td>
                        </div>
                    </tr>
                    <!--
                    Se a inscricao e na instituição também tem que fazer inscrição no mural
                    //-->
                    <?php if ($muralestagio->localInscricao === 1): ?>

                        <tr>
                            <td colspan=2>
                                <p style="text-align: center; color: red">Não esqueça de também fazer inscrição diretamente
                                    na instituição. Ambas são necessárias!</p>
                            </td>
                        </tr>

                    <?php endif; ?>

                    <!-- O administrador pode fazer inscrições sempre //-->
                    <?php if (isset($usuario) && $usuario->categoria_id == '1'): ?>
                        <tr>
                            <td colspan=2 style="text-align: center">
                                <?= $this->Html->link('Incricão administrador', ['controller' => 'muralinscricoes', 'action' => 'add', '?' => ['muralestagio_id' => $muralestagio->id, 'periodo' => trim($muralestagio->periodo)]]); ?>
                            </td>
                        </tr>
                    <?php elseif (isset($usuario) && $usuario->categoria_id <> 1): ?>
                        <!--
                        Para os outros usuários as inscrições dependem da data de encerramento
                        //-->
                        <?php
                        $timeZone = new DateTimeZone('America/Sao_Paulo');
                        $dataDeHoje = new DateTime(null, $timeZone);
                        /** Sem data de encerramento. Coloco a data de hoje e deixo aberto */
                        if (empty($muralestagio->dataInscricao)) {
                            $dataEnerramentoDaInscricao = new DateTime(null, $timeZone);
                        } else {
                            $dataEnerramentoDaInscricao = DateTime::createFromFormat('d-m-Y', $muralestagio->dataInscricao, $timeZone);
                        }
                        ?>
                        <tr>
                            <?php if ($dataDeHoje <= $dataEnerramentoDaInscricao): ?>
                                <td colspan=2 style="text-align: center">
                                    <?= $this->Html->link('Incricão', ['controller' => 'muralinscricoes', 'action' => 'add', '?' => ['muralestagio_id' => $muralestagio->id, 'periodo' => trim($muralestagio->periodo)]]); ?>
                                </td>
                            <?php else: ?>
                                <td colspan=2 style="text-align: center">
                                    <p style="text-align: center; color: red">Inscrições encerradas!</p>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div id="inscricoes" class="tab-pane fade">
                <h3><?= __('Inscrições para seleção de estágio') ?></h3>
                <?php if (!empty($muralestagio->muralinscricoes)): ?>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
                                <th class="actions"><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($muralestagio->muralinscricoes as $muralinscricoes): ?>
                            <tr>
                                <?php // pr($muralinscricoes) ?>
                                <td><?= h($muralinscricoes->id) ?></td>
                                <td><?= h($muralinscricoes->registro) ?></td>

                                <td><?= (isset($usuario) && $usuario->categoria_id == 1) ? $this->Html->link($muralinscricoes->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $muralinscricoes->estudante_id]) : $muralinscricoes->estudante->nome; ?>
                                </td>

                                <td><?= date('d-m-Y', strtotime(h($muralinscricoes->data))) ?></td>
                                <td><?= h($muralinscricoes->periodo) ?></td>
                                <?php if (isset($usuario) && $usuario->categoria_id == 1): ?>
                                    <td class="actions">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id]) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id]) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $muralinscricoes->id)]) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>Sem inscrições</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>