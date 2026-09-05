<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
$this->assign('title', 'Nova área');

$areaErrors = $area->getErrors()['area'] ?? [];
$errorList = [];
foreach ($areaErrors as $messages) {
    if (is_array($messages)) {
        foreach ($messages as $message) {
            if (is_string($message)) {
                $errorList[] = $message;
            }
        }
    } elseif (is_string($messages)) {
        $errorList[] = $messages;
    }
}
$hasErrors = count($errorList) > 0;
?>
<div class="ui-area-page">

    <nav class="ui-breadcrumb" aria-label="Trilha de navegação">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item"><?= $this->Html->link('Mural', '/') ?></li>
            <li class="breadcrumb-item"><span class="text-muted">Consulta</span></li>
            <li class="breadcrumb-item"><?= $this->Html->link('Áreas de instituições', ['action' => 'index']) ?></li>
            <li class="breadcrumb-item active" aria-current="page">Nova área</li>
        </ol>
    </nav>

    <div class="ui-pagehead">
        <div>
            <h1 class="mb-2">Nova área</h1>
            <p class="ui-pagehead-sub mb-0">Cadastre uma nova área para classificar as instituições de estágio do mural.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9 col-xl-8">
            <div class="ui-panel ui-panel--form">
                <?= $this->Form->create($area, ['id' => 'areaForm']) ?>
                <div class="ui-field">
                    <label class="form-label" for="areaName">
                        Nome da área <span class="ui-required" aria-hidden="true">*</span>
                    </label>
                    <input type="text" id="areaName" name="area" class="form-control<?= $hasErrors ? ' is-invalid' : '' ?>"
                           value="<?= h($area->area) ?>" maxlength="90" required autocomplete="off" autofocus>
                    <div class="ui-field-meta">
                        <span class="ui-hint">Como a instituição aparece classificada no mural.</span>
                        <span class="ui-counter" aria-live="polite"><span id="areaCount">0</span>/90</span>
                    </div>
                    <?php if ($hasErrors): ?>
                        <ul class="ui-field-errors">
                            <?php foreach ($errorList as $message): ?>
                                <li role="alert"><?= h($message) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="ui-form-actions">
                    <a class="btn btn-outline-secondary" href="<?= h($this->Url->build(['action' => 'index'])) ?>">Cancelar</a>
                    <button type="submit" class="btn btn-primary" id="areaSubmit">Salvar área</button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('areaName');
        const counter = document.getElementById('areaCount');
        const form = document.getElementById('areaForm');
        const submitBtn = document.getElementById('areaSubmit');

        if (input && counter) {
            const sync = function () {
                counter.textContent = String(input.value.length);
            };
            input.addEventListener('input', sync);
            sync();
        }
        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Salvando…';
            });
        }
    });
</script>
