<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
$this->assign('title', h($area->area));

$isAdmin = isset($user_data['categoria']) && $user_data['categoria'] === '1';
$instituicoes = $area->instituicoes ?? [];
$nInst = is_array($instituicoes) ? count($instituicoes) : 0;
$chipClass = $nInst === 0 ? 'ui-chip ui-chip--empty' : 'ui-chip';
$chipText = $nInst === 0
    ? 'Sem instituições vinculadas'
    : ($nInst === 1 ? '1 instituição vinculada' : $nInst . ' instituições vinculadas');
?>
<div class="ui-area-page">

    <nav class="ui-breadcrumb" aria-label="Trilha de navegação">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item"><?= $this->Html->link('Mural', '/') ?></li>
            <li class="breadcrumb-item"><span>Consulta</span></li>
            <li class="breadcrumb-item"><?= $this->Html->link('Áreas de instituições', ['action' => 'index']) ?></li>
            <li class="breadcrumb-item active" aria-current="page"><?= h($area->area) ?></li>
        </ol>
    </nav>

    <div class="ui-pagehead">
        <div>
            <h1 class="mb-2"><?= h($area->area) ?></h1>
            <p class="ui-pagehead-sub mb-0"><span class="<?= h($chipClass) ?>"><?= h($chipText) ?></span></p>
        </div>
        <div class="ui-pagehead-actions">
            <?php if ($isAdmin): ?>
                <a class="btn btn-outline-secondary" href="<?= $this->Url->build(['action' => 'index']) ?>">
                    <svg class="ui-ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Voltar
                </a>
                <a class="btn btn-primary" href="<?= $this->Url->build(['action' => 'edit', $area->id]) ?>">
                    <svg class="ui-ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 3a2.8 2.8 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                    Editar área
                </a>
                <?php if ($nInst === 0): ?>
                    <button type="button" class="btn btn-outline-danger" data-delete-area="<?= h($this->Url->build(['action' => 'delete', $area->id])) ?>" data-area-name="<?= h($area->area) ?>">
                        <svg class="ui-ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                        Excluir área
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-outline-danger" disabled title="Exclua ou reclassifique as instituições vinculadas antes de excluir a área.">Excluir área</button>
                <?php endif; ?>
            <?php else: ?>
                <a class="btn btn-outline-secondary" href="<?= $this->Url->build(['action' => 'index']) ?>">
                    <svg class="ui-ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
                    Voltar para as áreas
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="ui-panel">
        <div class="ui-panel-head">
            <h2>Instituições nesta área</h2>
            <?php if ($nInst > 0): ?>
                <a class="btn btn-sm btn-outline-secondary" href="<?= $this->Url->build(['controller' => 'Instituicoes', 'action' => 'index']) ?>">Ver todas as instituições</a>
            <?php endif; ?>
        </div>
        <?php if ($nInst > 0): ?>
            <ul class="ui-inst-list">
                <?php foreach ($instituicoes as $instituicao): ?>
                    <li>
                        <a class="ui-inst-link" href="<?= $this->Url->build(['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?>">
                            <span class="ui-inst-name"><?= h($instituicao->instituicao) ?></span>
                            <?php if (!empty($instituicao->municipio)): ?>
                                <span class="ui-inst-city"><?= h($instituicao->municipio) ?></span>
                            <?php endif; ?>
                            <svg class="ui-inst-chev ui-ic" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="ui-empty">
                <span class="ui-empty-icon" aria-hidden="true">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"/><path d="M15 9h4a2 2 0 0 1 2 2v10"/><path d="M9 7h2M9 11h2M9 15h2"/></svg>
                </span>
                <h2>Nenhuma instituição nesta área ainda</h2>
                <p>Quando instituições forem classificadas nesta área, elas aparecerão aqui com um link para o cadastro completo.</p>
                <a class="btn btn-outline-secondary" href="<?= $this->Url->build(['controller' => 'Instituicoes', 'action' => 'index']) ?>">Ver instituições cadastradas</a>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php if ($isAdmin && $nInst === 0): ?>
<div class="modal fade areas-modal" id="deleteAreaModal" tabindex="-1" aria-labelledby="deleteAreaModalTitle" aria-hidden="true">
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
                    <input type="hidden" name="_csrfToken" value="<?= h((string)$this->getRequest()->getAttribute('csrfToken')) ?>">
                    <button type="submit" class="btn btn-danger">Excluir área</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('deleteAreaModal');
    var form = document.getElementById('deleteAreaForm');
    var copy = document.getElementById('deleteAreaModalCopy');
    if (!modal || !form || !copy) { return; }
    var triggers = document.querySelectorAll('[data-delete-area]');
    Array.prototype.forEach.call(triggers, function (trigger) {
        trigger.addEventListener('click', function () {
            form.setAttribute('action', trigger.getAttribute('data-delete-area'));
            copy.textContent = 'A área “' + trigger.getAttribute('data-area-name') + '” será excluída definitivamente. Essa ação não pode ser desfeita.';
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
