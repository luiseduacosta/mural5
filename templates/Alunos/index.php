<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface|array<\App\Model\Entity\Aluno> $alunos
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>
<<<<<<< HEAD

<div class="container">

    <?php if (isset($categoria) && $categoria == 1): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
=======
<div class="alunos index content">
    <?php if (($user_data['categoria'] === '1' && $user_data['entidade_id']) || $user_data['aluno_id']) : ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light  w-75 mx-auto" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" 
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']) : ?>
>>>>>>> main
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo Aluno'), ['action' => 'add'], ['class' => 'button ms-2', 'style' => 'font-size: 10pt;']) ?>
                        <?= $this->Html->link(__('Buscar Aluno'), ['action' => 'busca'], ['class' => 'button ms-2', 'style' => 'font-size: 10pt;']) ?>
                    </li>
                </ul>
<<<<<<< HEAD
            </div>
            <?= $this->Form->end() ?>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Alunos', 'action' => 'buscaalunoregistro'], 'method' => 'post', 'class' => 'form-inline']) ?>
                <?= $this->Form->control('registro', [
                    'label' => false,
                    'placeholder' => 'Busca aluno(a) por DRE',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar registro"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
        <?php if (isset($categoria) && ($categoria == 1 || $categoria == 2)): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Inscrição para mural"),
                    ['controller' => 'Muralinscricoes', "action" => "add"],
                    ["class" => "btn btn-primary me-1", 'aria-disabled' => 'false'],
                ) ?>
            </li>
        <?php endif; ?>
        </ul>
    </nav>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#aluno1" role="tab"
                    aria-controls="Alunos dados pessoais" aria-selected="true">Alunos dados pessoais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#aluno2" role="tab"
                    aria-controls="Alunos comunicação" aria-selected="false">Alunos comunicação</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="tab-content">
            <div id="aluno1" class="tab-pane container active show">
                <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                    <h3><?= __("Alunos") ?></h3>
                    <table class="table table-striped table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th><?= $this->Paginator->sort("id", "ID") ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.registro",
                                    "Registro",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.nome",
                                    "Nome",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.nomesocial",
                                    "Nome social",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.nascimento",
                                    "Data de nascimento",
                                ) ?></th>
                                <th><?= $this->Paginator->sort("Alunos.cpf", "CPF") ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.identidade",
                                    "RG",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.orgao",
                                    "Órgão",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Alunos.ingresso",
                                    "Ingresso",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "Turnos.turno",
                                    "Turno",
                                ) ?></th>
                                <?php if (
                                    isset($categoria) &&
                                    $categoria == 1
                                ): ?>
                                    <th><?= __("Ações") ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?= $aluno->id ?></td>
                                    <td><?= $aluno->registro ?></td>
                                    <td><?= $this->Html->link($aluno->nome, [
                                        "controller" => "Alunos",
                                        "action" => "view",
                                        $aluno->id,
                                    ]) ?>
                                    </td>
                                    <td><?= h($aluno->nomesocial) ?></td>
                                    <?php if (empty($aluno->nascimento)): ?>
                                        <td>Sem dados</td>
                                    <?php else: ?>
                                        <td><?= $aluno->nascimento->i18nFormat(
                                            "dd-MM-yyyy",
                                        ) ?></td>
                                    <?php endif; ?>
                                    <td><?= h($aluno->cpf) ?></td>
                                    <td><?= h($aluno->identidade) ?></td>
                                    <td><?= h($aluno->orgao) ?></td>
                                    <td><?= h($aluno->ingresso) ?></td>
                                    <td><?= $aluno->turnoID->turno ?? 's/d' ?></td>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__("Ver"), [
                                            "controller" => "Alunos",
                                            "action" => "view",
                                            $aluno->id,
                                        ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                        <?php if (
                                            isset($categoria) &&
                                            $categoria == 1
                                        ): ?>
                                            <?= $this->Html->link(__("Editar"), [
                                                "controller" => "Alunos",
                                                "action" => "edit",
                                                $aluno->id,
                                            ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                            <?= $this->Form->postLink(
                                                __("Excluir"),
                                                [
                                                    "controller" => "Alunos",
                                                    "action" => "delete",
                                                    $aluno->id,
                                                ],
                                                [
                                                    "confirm" => __(
                                                        "Tem certeza que quer excluir o registro # {0}?",
                                                        $aluno->id,
                                                    ),
                                                    'class' => 'btn btn-danger btn-sm btn-block mb-1',
                                                ],
                                            ) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tab-content">
                <div id="aluno2" class="tab-pane container fade">
                    <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                        <h3><?= __("Alunos comunicação") ?></h3>
                        <table class="table table-striped table-hover table-responsive">
                            <thead class="table-dark">
                                <tr>
                                    <th><?= $this->Paginator->sort("id", "ID") ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "registro",
                                        "Registro",
                                    ) ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "nome",
                                        "Nome",
                                    ) ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "email",
                                        "E-mail",
                                    ) ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "codigo_telefone",
                                        "DDD",
                                    ) ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "telefone",
                                        "Telefone",
                                    ) ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "codigo_celular",
                                        "DDD",
                                    ) ?></th>
                                    <th><?= $this->Paginator->sort(
                                        "celular",
                                        "Celular",
                                    ) ?></th>
                                    <th><?= __("Ações") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alunos as $aluno): ?>
                                    <tr>
                                        <td><?= $aluno->id ?></td>
                                        <td><?= $aluno->registro ?></td>
                                        <td><?= $this->Html->link($aluno->nome, [
                                            "controller" => "Alunos",
                                            "action" => "view",
                                            $aluno->id,
                                        ]) ?>
                                        </td>
                                        <td><?= h($aluno->email) ?></td>
                                        <td><?= $this->Number->format(
                                            $aluno->codigo_telefone,
                                        ) ?></td>
                                        <td><?= h($aluno->telefone) ?></td>
                                        <td><?= $this->Number->format(
                                            $aluno->codigo_celular,
                                        ) ?></td>
                                        <td><?= h($aluno->celular) ?></td>
                                        <td class="d-grid">
                                            <?= $this->Html->link(__("Ver"), [
                                                "controller" => "Alunos",
                                                "action" => "view",
                                                $aluno->id,
                                            ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                            <?php if (
                                                isset($categoria) &&
                                                $categoria == 1
                                            ): ?>
                                                <?= $this->Html->link(
                                                    __("Editar"),
                                                    [
                                                        "controller" => "Alunos",
                                                        "action" => "edit",
                                                        $aluno->id,
                                                    ],
                                                    ["class" => "btn btn-primary btn-sm btn-block mb-1"]
                                                ) ?>
                                                <?= $this->Form->postLink(
                                                    __("Excluir"),
                                                    [
                                                        "controller" => "Alunos",
                                                        "action" => "delete",
                                                        $aluno->id,
                                                    ],
                                                    [
                                                        "confirm" => __(
                                                            "Tem certeza que quer excluir o registro # {0}?",
                                                            $aluno->id,
                                                        ),
                                                        'class' => 'btn btn-danger btn-sm btn-block mb-1',
                                                    ],
                                                ) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $this->element("paginator") ?>

    </div>
=======
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>
    <h3><?= __('Lista de Alunos(as)') ?></h3>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
    </div>
    <div class="table_wrap">
        <table>
            <thead>
                <tr>
                    <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']) : ?>
                        <th class="actions"><?= __('Ações') ?></th>
                        <th><?= $this->Paginator->sort('id') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('registro') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('celular') ?></th>
                    <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                    <th><?= $this->Paginator->sort('ingresso', 'Ingresso') ?></th>
                    <th><?= $this->Paginator->sort('Turnos.turno', 'Turno') ?></th>
                    <th><?= $this->Paginator->sort('inscricao_count', 'Inscrições') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno) : ?>
                <tr>
                    <?php if ($user_data['categoria'] === '1' && $user_data['entidade_id']) : ?>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $aluno->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $aluno->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete {0}?', $aluno->nome)]) ?>
                    </td>
                    <td><?= $this->Html->link((string)$aluno->id, ['action' => 'view', $aluno->id]) ?></td>
                    <?php endif; ?>
                    <td><?= $aluno->nome ? $this->Html->link(h($aluno->nome), ['action' => 'view', $aluno->id]) : '' ?></td>
                    <td><?= h($aluno->registro) ?></td>
                    <td><?= $aluno->email ? $this->Html->link(h($aluno->email), ['mailto' => $aluno->email]) : '' ?></td>
                    <?php if (!empty((string)$aluno->telefone) && strlen((string)$aluno->telefone) < 10) : ?>
                        <td><?= $aluno->telefone ? '(' . $aluno->codigo_telefone . ') ' . h($aluno->telefone) : '' ?></td>
                    <?php else : ?>
                        <td><?= h($aluno->telefone) ?></td>
                    <?php endif; ?>
                    <?php if (!empty((string)$aluno->celular) && strlen((string)$aluno->celular) < 10) : ?>
                        <td><?= $aluno->celular ? '(' . $aluno->codigo_celular . ') ' . h($aluno->celular) : '' ?></td>
                    <?php else : ?>
                        <td><?= h($aluno->celular) ?></td>
                    <?php endif; ?>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->ingresso) ?? 's/d' ?></td>
                    <td><?= h($aluno->TurnoID->turno ?? '') ?></td>
                    <td><?= h($aluno->inscricao_count) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <?= $this->element('paginator'); ?>
        <?= $this->element('paginator_count'); ?>
    </div>
</div>
>>>>>>> main
