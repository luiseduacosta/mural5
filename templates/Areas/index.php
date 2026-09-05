<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area[]|\Cake\Collection\CollectionInterface $areas
 */
$this->assign('title', 'Áreas de instituições');

$isAdmin = isset($user_data['categoria']) && $user_data['categoria'] === '1';
$q = $q ?? '';
$totalAreas = (int)($totalAreas ?? 0);
$areasComInstituicoes = (int)($areasComInstituicoes ?? 0);
$hasAreas = $areas->count() > 0;
$filteredEmpty = $q !== '' && !$hasAreas;
$sortParam = (string)$this->request->getQuery('sort');
$dirParam = strtolower((string)$this->request->getQuery('direction'));
$ariaSort = ($sortParam === 'Areas.area' || $sortParam === 'area')
    ? ($dirParam === 'desc' ? 'descending' : 'ascending')
    : 'none';
$hasPagination = (int)$this->Paginator->param('pageCount') > 1;
?>

<div class="ui-area-page">

    <nav class="ui-breadcrumb" aria-label="Trilha de navegação">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item"><?= $this->Html->link('Mural', '/') ?></li>
            <li class="breadcrumb-item"><span class="text-muted">Consulta</span></li>
            <li class="breadcrumb-item active" aria-current="page">Áreas de instituições</li>
        </ol>
    </nav>

    <div class="ui-pagehead">
        <div class="ui-pagehead-titles">
            <h1>Áreas de instituições</h1>
            <p class="ui-pagehead-sub">
                <?= $totalAreas === 1 ? '1 área cadastrada' : $totalAreas . ' áreas cadastradas' ?>
                ·
                <?= $areasComInstituicoes === 1
                    ? '1 com instituições vinculadas'
                    : $areasComInstituicoes . ' com instituições vinculadas' ?>
            </p>
        </div>
        <div class="ui-pagehead-actions">
            <a class="btn btn-outline-secondary"
               href="<?= h($this->Url->build(['controller' => 'Instituicoes', 'action' => 'index'])) ?>">
                <svg class="ui-ic" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 21h18"/><path d="M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"/>
                    <path d="M15 9h4a2 2 0 0 1 2 2v10"/><path d="M9 7h2M9 11h2M9 15h2"/>
                </svg>
                Ver instituições
            </a>
            <?php if ($isAdmin): ?>
                <a class="btn btn-primary" href="<?= h($this->Url->build(['action' => 'add'])) ?>">
                    <svg class="ui-ic" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" aria-hidden="true">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Nova área
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($hasAreas || $q !== ''): ?>
        <div class="ui-toolbar">
            <form method="get" action="<?= h($this->Url->build(['action' => 'index'])) ?>" class="ui-search"
                  role="search">
                <label class="visually-hidden" for="areaSearch">Buscar área pelo nome</label>
                <span class="ui-search-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round">
                        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
                    </svg>
                </span>
                <input class="form-control" type="search" id="areaSearch" name="q" value="<?= h($q) ?>"
                       placeholder="Buscar área pelo nome" autocomplete="off">
                <button class="btn btn-primary" type="submit">Buscar</button>
                <?php if ($q !== ''): ?>
                    <a class="ui-search-clear" href="<?= h($this->Url->build(['action' => 'index'])) ?>">Limpar busca</a>
                <?php endif; ?>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($hasAreas): ?>
        <div class="ui-panel ui-panel--table">
            <table class="table align-middle mb-0 ui-areas-table">
                <thead>
                <tr>
                    <th scope="col" aria-sort="<?= $ariaSort ?>"><?= $this->Paginator->sort('area', 'Área') ?></th>
                    <th scope="col">Instituições vinculadas</th>
                    <?php if ($isAdmin): ?>
                        <th scope="col" class="text-end">Ações</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($areas as $area):
                    $nInst = is_countable($area->instituicoes ?? []) ? count($area->instituicoes) : 0;
                    $chipText = $nInst === 0
                        ? 'Sem instituições'
                        : ($nInst === 1 ? '1 instituição' : $nInst . ' instituições');
                    ?>
                    <tr>
                        <td data-label="Área">
                            <a class="ui-area-link"
                               href="<?= h($this->Url->build(['action' => 'view', $area->id])) ?>">
                                <?= h($area->area) ?>
                            </a>
                        </td>
                        <td data-label="Instituições vinculadas">
                            <span class="ui-chip<?= $nInst === 0 ? ' ui-chip--empty' : '' ?>"><?= $chipText ?></span>
                        </td>
                        <?php if ($isAdmin): ?>
                            <td class="text-end ui-actions">
                                <?= $this->Html->link('Ver', ['action' => 'view', $area->id],
                                    ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                <?= $this->Html->link('Editar', ['action' => 'edit', $area->id],
                                    ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                <?php if ($nInst > 0): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger" disabled
                                            title="Exclua ou reclassifique as instituições vinculadas antes de excluir a área.">
                                        Excluir
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-delete-area="<?= h($this->Url->build(['action' => 'delete', $area->id])) ?>"
                                            data-area-name="<?= h($area->area) ?>">
                                        Excluir
                                    </button>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($hasPagination): ?>
            <div class="ui-pagination"><?= $this->element('paginator') ?></div>
        <?php endif; ?>
        <div class="ui-pagination-count"><?= $this->element('paginator_count') ?></div>

    <?php elseif ($filteredEmpty): ?>
        <div class="ui-panel">
            <div class="ui-empty">
                <span class="ui-empty-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round">
                        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
                    </svg>
                </span>
                <h2>Nenhuma área encontrada</h2>
                <p>Nenhuma área corresponde a “<?= h($q) ?>”. Verifique o termo digitado ou limpe a busca.</p>
                <a class="btn btn-outline-secondary" href="<?= h($this->Url->build(['action' => 'index'])) ?>">
                    Limpar busca
                </a>
            </div>
        </div>

    <?php else: ?>
        <div class="ui-panel">
            <div class="ui-empty">
                <span class="ui-empty-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21h18"/><path d="M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"/>
                        <path d="M15 9h4a2 2 0 0 1 2 2v10"/><path d="M9 7h2M9 11h2M9 15h2"/>
                    </svg>
                </span>
                <h2>Nenhuma área cadastrada ainda</h2>
                <p>
                    <?= $isAdmin
                        ? 'Cadastre a primeira área para classificar as instituições de estágio do mural.'
                        : 'As áreas de instituições aparecerão aqui quando a coordenação cadastrar.' ?>
                </p>
                <?php if ($isAdmin): ?>
                    <a class="btn btn-primary" href="<?= h($this->Url->build(['action' => 'add'])) ?>">Nova área</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php if ($isAdmin && $hasAreas): ?>
    <div class="modal fade areas-modal" id="deleteAreaModal" tabindex="-1"
         aria-labelledby="deleteAreaModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title h5 mb-0" id="deleteAreaModalTitle">Excluir área</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="deleteAreaModalCopy"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteAreaForm" method="post" action="">
                        <input type="hidden" name="_csrfToken"
                               value="<?= h((string)$this->getRequest()->getAttribute('csrfToken')) ?>">
                        <button type="submit" class="btn btn-danger">Excluir área</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('deleteAreaModal');
            if (!modal) {
                return;
            }
            const form = document.getElementById('deleteAreaForm');
            const copy = document.getElementById('deleteAreaModalCopy');
            document.querySelectorAll('[data-delete-area]').forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    form.setAttribute('action', trigger.getAttribute('data-delete-area'));
                    const name = trigger.getAttribute('data-area-name');
                    copy.textContent = 'A área “' + name +
                        '” será excluída definitivamente. Essa ação não pode ser desfeita.';
                    if (window.bootstrap && window.bootstrap.Modal) {
                        window.bootstrap.Modal.getOrCreateInstance(modal).show();
                    } else if (window.confirm(copy.textContent)) {
                        form.submit();
                    }
                });
            });
        });
    </script>
<?php endif; ?>
