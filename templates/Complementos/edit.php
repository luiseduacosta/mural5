<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
$categoria = $this->getRequest()->getAttribute('params')['categoria'] ?? null;
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $complemento->id],
                    ['confirm' => __('Tem certeza que quer excluir # {0}?', $complemento->id), 'class' => 'btn btn-danger']
                )
                ?>
                <?= $this->Html->link(__('Listar complemento do estágio'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="complementos form content">
                <?= $this->Form->create($complemento) ?>
                <fieldset>
                    <legend><?= __('Editar complemento de estágio') ?></legend>
                    <?php if (isset($categoria) && $categoria == 1): ?>
                        <?php
                        echo $this->Form->control('periodo_especial', ['label' => 'Período especial']);
                        ?>
                    <?php endif; ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
