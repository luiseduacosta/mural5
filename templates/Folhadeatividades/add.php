<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
// pr($folhadeatividades);
// pr($estagiario);
// die();
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
                    <?= $this->Html->link(__('Listar atividades'), ['controller' => 'folhadeatividades', 'action' => 'index', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary float-end']) ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <?php if (isset($folhadeatividades)): ?>
            <h3>Últimas 5 atividades</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th>Id</th>
                        <th>Data</th>
                        <th>Início</th>
                        <th>Final</th>
                        <th>Horário</th>
                        <th>Atividade</th>
                    </tr>
                    <?php /** Últimos 5 registros */ ?>
                    <?php $i = 0 ?>
                    <?php $total = count($folhadeatividades->toArray()); ?>
                    <?php $ultimos = $total - 6; ?>
                    <?php foreach ($folhadeatividades as $folhadeatividade): ?>
                        <tr>
                            <?php if ($i > $ultimos): ?>
                                <?php // pr($folhadeatividade) ?>
                                <td><?= $folhadeatividade->id ?></td>
                                <td><?= $folhadeatividade->dia ?></td>
                                <td><?= $folhadeatividade->inicio ?></td>
                                <td><?= $folhadeatividade->final ?></td>
                                <td><?= $folhadeatividade->horario ?></td>
                                <td><?= $folhadeatividade->atividade ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            <?php echo 'Sem atividades' . '<br>' ?>
        <?php endif; ?>

        <?= $this->Form->create($folhadeatividade, ['type' => 'post']) ?>
        <fieldset>
            <legend><?= __('Adiciona uma atividade') ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome]], 'readonly');
            echo $this->Form->control('dia');
            echo $this->Form->control('inicio', ['label' => ['text' => 'Horário de início']]);
            echo $this->Form->control('final', ['label' => ['text' => 'Horário de finalização']]);
            echo $this->Form->control('atividade', ['label' => ['text' => 'Atividade realizada']]);
            echo $this->Form->control('horario', ['type' => 'hidden', 'value' => null]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>

    </div>
</div>