<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Administrador $administrador
 * @var \App\Model\Entity\User[] $administradores
 */
declare(strict_types=1);

pr($administradores);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<div>
    <div class="column-responsive column-80">
        <div class="administradores form content">
            <aside>
                <div class="nav">
                    <?= $this->Html->link(__('Listar Administradores'), ['action' => 'index'], ['class' => 'button', 'style' => 'font-size: 10pt;']) ?>
                </div>
            </aside>
            <?php if ($user_data['categoria'] == '1') : ?>
                <?= $this->Form->create($administrador) ?>
                <fieldset>
                    <h3><?= __('Adicionar administrador') ?></h3>
                    <?php
                        echo $this->Form->control('nome', ['label' => 'Nome']);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Adicionar'), ['class' => 'button']) ?>
                <?= $this->Form->end() ?>
            <?php endif; ?>
        </div>
    </div>
</div>
