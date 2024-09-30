<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
// pr($estagiario);
?>

<?= $this->element('templates') ?>

<div class="container">
    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <?= $this->Html->link(__('Listar Folha de atividades'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </div>
        </aside>
        <div class="container">
            <?= $this->Form->create($folhadeatividade) ?>
            <fieldset>
                <legend><?= __('Adiciona uma atividade') ?></legend>
                <?php
                echo $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->estudante->nome], 'readonly']);
                echo $this->Form->control('dia');
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                echo "Horário de início";
                echo "</td>";
                echo "<td>";
                echo $this->Form->control('inicio', ['label' => false]);
                echo "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>";
                echo "Horário de finalização";
                echo "</td>";
                echo "<td>";
                echo $this->Form->control('final', ['label' => false]);
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo $this->Form->control('atividade');
                echo $this->Form->control('horario', ['type' => 'hidden']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>