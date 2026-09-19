<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 page-header">
        <div>
            <h1 class="mb-1"><?= h($professor->nome) ?></h1>
            <p class="text-muted mb-0">Dados do docente, vínculos e acompanhamento de estagiários.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <?php if ($user_data['categoria'] === '1'): ?>
                <?= $this->Html->link(__('Notas e CH'), ['controller' => 'Estagiarios', 'action' => 'lancanota', '?' => ['professor_id' => $professor->id]], ['class' => 'btn btn-primary']) ?>
                <?= $this->Html->link(__('Listar Professores(as)'), ['action' => 'index'], ['class' => 'btn btn-outline-secondary']) ?>
                <?= $this->Html->link(__('Novo(a) Professor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                <?= $this->Form->postLink(__('Excluir Professor(a)'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $professor->id), 'class' => 'btn btn-danger']) ?>
            <?php endif; ?>

            <?php if ($user_data['professor_id']): ?>
                <?= $this->Html->link(__('Notas e CH'), ['controller' => 'Estagiarios', 'action' => 'lancanota', '?' => ['professor_id' => $professor->id]], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-fill border-0 px-3 pt-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#professor" type="button" role="tab">Professor(a)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#estagiarios" type="button" role="tab">Estagiários</button>
                </li>
                <?php if ($user_data['professor_id'] || $user_data['categoria'] === '1'): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notas" type="button" role="tab">Notas e CH</button>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="tab-content p-3">
                <div id="professor" class="tab-pane fade show active">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <td><?= $professor->id ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Siape') ?></th>
                                <td><?= $professor->siape ?></td>
                            </tr>
                            <tr>
                                <th><?= __('CRESS') ?></th>
                                <td><?= $professor->cress ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Região') ?></th>
                                <td><?= $professor->regiao ? h($professor->regiao) : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Nome') ?></th>
                                <td><?= h($professor->nome) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('CPF') ?></th>
                                <td><?= h($professor->cpf) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Telefone') ?></th>
                                <td><?= h($professor->telefone) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Celular') ?></th>
                                <td><?= h($professor->celular) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('E-mail') ?></th>
                                <td><?= h($professor->email) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Currículo Lattes') ?></th>
                                <td><?= h($professor->curriculolattes) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Atualização Lattes') ?></th>
                                <td><?= $professor->atualizacaolattes ? date('d-m-Y', strtotime(h($professor->atualizacaolattes))) : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Data de ingresso') ?></th>
                                <td><?= $professor->dataingresso ? date('d-m-Y', strtotime(h($professor->dataingresso))) : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Departamento') ?></th>
                                <td><?= h($professor->departamento) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Tipo de Cargo') ?></th>
                                <td><?= $professor->tipocargo ? h($professor->tipocargo) : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Status') ?></th>
                                <td><?= $professor->status !== null ? $professor->status : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Quantidade de Estagiários') ?></th>
                                <td><?= $professor->estagiarios_count ?? 0 ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Motivo egresso') ?></th>
                                <td><?= h($professor->motivoegresso) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Data de egresso') ?></th>
                                <td><?= $professor->dataegresso ? date('d-m-Y', strtotime(h($professor->dataegresso))) : ' ' ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-4">
                        <strong><?= __('Observações') ?></strong>
                        <blockquote class="blockquote mb-0 mt-2">
                            <?= $this->Text->autoParagraph(h($professor->observacoes)); ?>
                        </blockquote>
                    </div>
                </div>

                <div id="estagiarios" class="tab-pane fade">
                    <?php if (!empty($professor->estagiarios)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <tr>
                                    <?php if ($user_data['categoria'] === '1'): ?>
                                        <th><?= __('Id') ?></th>
                                    <?php endif; ?>
                                    <th><?= __('Aluno') ?></th>
                                    <th><?= __('Registro') ?></th>
                                    <th><?= __('Ajuste 2020') ?></th>
                                    <th><?= __('Turno') ?></th>
                                    <th><?= __('Nível') ?></th>
                                    <th><?= __('Instituição') ?></th>
                                    <th><?= __('Supervisora') ?></th>
                                    <th><?= __('Período') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                                <?php foreach ($professor->estagiarios as $estagiarios): ?>
                                    <tr>
                                        <?php if ($user_data['categoria'] === '1'): ?>
                                            <td><?= h($estagiarios->id) ?></td>
                                        <?php endif; ?>
                                        <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                                        <td><?= h($estagiarios->registro) ?></td>
                                        <td><?= h($estagiarios->ajuste2020) ?></td>
                                        <td><?= $estagiarios->hasValue('aluno') ? h($estagiarios->aluno->turno) : '' ?></td>
                                        <td><?= h($estagiarios->nivel) ?></td>
                                        <td><?= $estagiarios->hasValue('instituicao') ? $estagiarios->instituicao->instituicao : '' ?></td>
                                        <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                        <td><?= h($estagiarios->periodo) ?></td>
                                        <td><?= h($estagiarios->nota) ?></td>
                                        <td><?= h($estagiarios->ch) ?></td>
                                        <td class="actions d-flex gap-2 flex-wrap">
                                            <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                            <?php if ($user_data['categoria'] === '1'): ?>
                                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id), 'class' => 'btn btn-sm btn-outline-danger']) ?>
                                            <?php endif; ?>
                                            <?php if ($user_data['categoria'] === '3'): ?>
                                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="notas" class="tab-pane fade">
                    <?php if (!empty($professor->estagiarios)): ?>
                        <div class="table-responsive">
                            <table id="table-estagiarios" class="table table-striped table-hover align-middle mb-0">
                                <thead>
                                <tr>
                                    <?php if ($user_data['categoria'] === '1'): ?>
                                        <th><?= __('Id') ?></th>
                                    <?php endif; ?>
                                    <th><?= __('Aluno') ?></th>
                                    <th><?= __('Registro') ?></th>
                                    <th><?= __('Atividades') ?></th>
                                    <th><?= __('Avaliação estágio') ?></th>
                                    <th><?= __('Nível') ?></th>
                                    <th><?= __('Instituição') ?></th>
                                    <th><?= __('Supervisora') ?></th>
                                    <th><?= __('Período') ?></th>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th class="actions"><?= __('Ações') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($professor->estagiarios as $estagiarios): ?>
                                    <tr data-id="<?= h($estagiarios->id) ?>">
                                        <?php if ($user_data['categoria'] === '1'): ?>
                                            <td><?= h($estagiarios->id) ?></td>
                                        <?php endif; ?>
                                        <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                                        <td><?= h($estagiarios->registro) ?></td>

                                        <?php if (($user_data['categoria'] === '1') || $user_data['aluno_id']): ?>
                                            <td><?= $estagiarios->hasValue('folhadeatividade') ? $this->Html->link('Atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'index', $estagiarios->id]) : $this->Html->link('Cadastrar atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiarios->id]]) ?></td>
                                        <?php else: ?>
                                            <td><?= $estagiarios->hasValue('folhadeatividade') ? $this->Html->link('Atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'index', $estagiarios->id]) : 'Sem atividades cadastradas' ?></td>
                                        <?php endif; ?>
                                        <td><?= $estagiarios->hasValue('avaliacao') ? $this->Html->link('Avaliação de estágio', ['controller' => 'avaliacoes', 'action' => 'view', '?' => ['estagiario_id' => $estagiarios->id]]) : 'Sem avaliações cadastradas' ?></td>
                                        <td><?= h($estagiarios->nivel) ?></td>
                                        <td><?= $estagiarios->hasValue('instituicao') ? $estagiarios->instituicao->instituicao : '' ?></td>
                                        <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : '' ?></td>
                                        <td><?= h($estagiarios->periodo) ?></td>
                                        <td class="text-center editable-field" data-field="nota"><?= h($estagiarios->nota) ?></td>
                                        <td class="text-center editable-field" data-field="ch"><?= h($estagiarios->ch) ?></td>
                                        <td class="actions d-flex gap-2 flex-wrap">
                                            <?= $this->Html->link(__('Atividades'), ['controller' => 'Folhadeatividades', 'action' => 'index', '?' => ['estagiario_id' => $estagiarios->id]], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                            <?php if ($user_data['categoria'] === '1' || $user_data['categoria'] === '3'): ?>
                                                <button class="btn btn-sm btn-warning btn-edit">Editar</button>
                                                <button class="btn btn-sm btn-primary btn-save" style="display:none">Salvar</button>
                                                <button class="btn btn-sm btn-secondary btn-cancel" style="display:none">Cancelar</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#table-estagiarios tbody');
    if (!tableBody) return;

    tableBody.addEventListener('click', (event) => {
        const target = event.target;
        const row = target.closest('tr');
        if (!row) return;

        if (target.classList.contains('btn-edit')) {
            makeRowEditable(row);
        } else if (target.classList.contains('btn-save')) {
            saveRow(row);
        } else if (target.classList.contains('btn-cancel')) {
            cancelEdit(row);
        }
    });
});

function makeRowEditable(row) {
    row.classList.add('editing');
    const cells = row.querySelectorAll('.editable-field');
    cells.forEach(cell => {
        const text = cell.textContent.trim();
        cell.dataset.original = text;
        const field = cell.dataset.field;
        const escaped = text.replace(/"/g, '&quot;');
        let attrs;
        if (field === 'nota') {
            attrs = 'type="number" inputmode="decimal" min="0" max="99.99" step="0.01"';
        } else if (field === 'ch') {
            attrs = 'type="number" inputmode="numeric" min="0" max="32767" step="1"';
        } else {
            attrs = 'type="text"';
        }
        cell.innerHTML = `<input class="form-control form-control-sm" ${attrs} value="${escaped}">`;
    });

    row.querySelector('.btn-edit').style.display = 'none';
    row.querySelector('.btn-save').style.display = 'inline-block';
    row.querySelector('.btn-cancel').style.display = 'inline-block';
}

function normalizeField(field, raw) {
    const value = String(raw).trim();
    if (value === '') {
        return { ok: true, value: '', display: '' };
    }
    if (field === 'nota') {
        const normalized = value.replace(',', '.');
        if (!/^\d{1,2}(\.\d{1,2})?$/.test(normalized)) {
            return { ok: false, message: 'Nota inválida. Use formato 0.00 a 99.99 (até 2 casas).' };
        }
        const n = parseFloat(normalized);
        if (Number.isNaN(n) || n < 0 || n > 99.99) {
            return { ok: false, message: 'Nota fora do intervalo permitido (0 a 99.99).' };
        }
        const fixed = n.toFixed(2);
        return { ok: true, value: fixed, display: fixed };
    }
    if (field === 'ch') {
        if (!/^\d+$/.test(value)) {
            return { ok: false, message: 'CH inválida. Use apenas números inteiros não negativos.' };
        }
        const n = parseInt(value, 10);
        if (n < 0 || n > 1000) {
            return { ok: false, message: 'CH fora do intervalo permitido (0 a 1000).' };
        }
        return { ok: true, value: String(n), display: String(n) };
    }
    return { ok: true, value: value, display: value };
}

function saveRow(row) {
    const cells = row.querySelectorAll('.editable-field');
    const data = { id: row.dataset.id };
    const normalized = [];

    for (const cell of cells) {
        const input = cell.querySelector('input');
        const fieldName = cell.dataset.field;
        const result = normalizeField(fieldName, input ? input.value : '');
        if (!result.ok) {
            alert(result.message);
            input && input.focus();
            return;
        }
        normalized.push({ cell, fieldName, result });
    }

    normalized.forEach(({ cell, fieldName, result }) => {
        cell.textContent = result.display;
        delete cell.dataset.original;
        data[fieldName] = result.value;
    });

    $.ajax({
        url: '<?= $this->Url->build(['controller' => 'Estagiarios', 'action' => 'edit']) ?>',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        headers: {
            'X-CSRF-Token': '<?= $this->request->getAttribute('csrfToken') ?>',
            'Accept': 'application/json'
        },
        data: $.param(data),
        success: function(response) {
            console.log('Success:', response);
            if (response.status === 'success') {
                const saveBtn = row.querySelector('.btn-save');
                saveBtn.textContent = 'Salvo!';
                saveBtn.classList.remove('btn-primary');
                saveBtn.classList.add('btn-success');

                setTimeout(() => {
                    row.classList.remove('editing');
                    row.querySelector('.btn-edit').style.display = 'inline-block';
                    saveBtn.style.display = 'none';
                    saveBtn.textContent = 'Salvar';
                    saveBtn.classList.remove('btn-success');
                    saveBtn.classList.add('btn-primary');
                    row.querySelector('.btn-cancel').style.display = 'none';
                }, 1000);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error details:', xhr.responseText);
            alert('Erro ao salvar as alterações. Verifique o console para mais detalhes.');
        }
    });
}

function cancelEdit(row) {
    row.classList.remove('editing');
    const cells = row.querySelectorAll('.editable-field');
    cells.forEach(cell => {
        cell.textContent = cell.dataset.original ?? '';
        delete cell.dataset.original;
    });

    row.querySelector('.btn-edit').style.display = 'inline-block';
    row.querySelector('.btn-save').style.display = 'none';
    row.querySelector('.btn-cancel').style.display = 'none';
}
</script>
