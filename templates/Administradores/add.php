<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $nome
 */
?>
<div
    <div class="column-responsive column-80">
        <div class="administradores form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'button']) ?>
                </div>
            </aside>
            <?= $this->Form->create($administrador) ?>
            <fieldset>
                <h3><?= __('Adicionando Administrador') ?></h3>
                <?php
                    if ($categoria == 1):
                        $val = $this->request->getParam('pass') ? $this->request->getParam('pass')[0] : '';
                        echo $this->Form->control('user_id', ['type' => 'number', 'value' => $val ]); 
                    endif;
                    echo $this->Form->control('nome');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Adicionar'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
