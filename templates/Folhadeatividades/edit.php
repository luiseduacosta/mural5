<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
// pr($estagiario);
?>

<?= $this->element('templates') ?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerUsuario" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <li class="nav-item">
                    <?=
                        $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $folhadeatividade->id],
                            ['confirm' => __('Tem certeza que quer excluir esta atividade # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger float-end']
                        )
                        ?>
                </li>
                <li class="nav-link">
                    <?= $this->Html->link(__('Lista de atividades'), ['action' => 'index', $estagiario->estagiario->id], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?= $this->Form->create($folhadeatividade) ?>
        <fieldset>
            <legend><?= __('Edita atividade') ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', ['options' => [$estagiario->estagiario->id => $estagiario->estagiario->aluno->nome]]);
            echo $this->Form->control('dia');
            echo "<table>";
            echo "<tr>";
            echo "<td>";
            echo "Horário de início";
            echo "</td>";
            echo "<td>";
            echo $this->Form->control('inicio', ['label' => False]);
            echo "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td>";
            echo "Horário de finalização";
            echo "</td>";
            echo "<td>";

            echo $this->Form->control('final', ['label' => False]);
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            echo $this->Form->control('horario', ['type' => 'hidden', 'empty' => true]);
            echo $this->Form->control('atividade');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>