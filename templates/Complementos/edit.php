<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
?>
<?= $this->element('templates') ?>

<div class="container">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerComplemento"
                aria-controls="navbarTogglerComplemento" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerComplemento">
                <ul class="navbar-nav ms-auto mt-lg-0">
                    <?php if ($user->isAdmin()): ?>
                    <li class="nav-item">
                        <?=
                        $this->Form->postLink(
                                __('Excluir'),
                                ['action' => 'delete', $complemento->id],
                        ['confirm' => __('Tem certeza que quer excluir # {0}?', $complemento->id), 'class' => 'btn btn-danger me-1']
                )
                ?>
                <?php endif; ?>
                <?= $this->Html->link(__('Listar complemento do estágio'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </div>
        </nav>

        <div class="table-responsive">
                <?= $this->Form->create($complemento) ?>
                <fieldset>
                    <legend><?= __('Editar complemento de estágio') ?></legend>
                    <?php
                    echo $this->Form->control('periodo_especial');
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary me-1']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
</div>