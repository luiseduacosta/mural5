<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
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
<?php if($user->isAdmin()): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar aluno(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary me-1'])
                    ?>
                </li>
<?php endif; ?>
            </ul>
        </div>
    </nav>

<?php if($user->isAdmin()): ?>

    <table class='table table-hover table-striped table-responsive'>
        <thead class='thead-light'>
            <tr>
                <th>Id</th>
                <th><?= $this->Html->link("Registro", ['controller' => 'alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'registro']]); ?>
                </th>
                <th><?= $this->Html->link("Semestres", ['controller' => 'alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'q_semestres']]); ?>
                </th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 1</th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 2</th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 3</th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 4</th>
                <th><?= $this->Html->link("Total", ['controller' => 'alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'ch_total']]); ?>
                </th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($cargahorariatotal as $c_cargahorariatotal): ?>
            <tr>

                <td>
                    <?php echo $i++; ?>
                </td>

                <td>
                    <?php // echo $this->Html->link($c_cargahorariatotal['registro'], '/alunos/view/' . $c_cargahorariatotal['id']); ?>
                </td>

                <td>
                    <?php echo $c_cargahorariatotal['q_semestres']; ?>
                </td>

                <?php foreach ($c_cargahorariatotal as $cada_cargahorariatotal): ?>
                    <?php // pr($cada_cargahorariatotal); ?>
                    <?php if (is_array($cada_cargahorariatotal)): ?>

                        <td>
                            <?php echo $cada_cargahorariatotal['nivel']; ?>
                        </td>

                        <td>
                            <?php echo $cada_cargahorariatotal['periodo']; ?>
                        </td>
                        <td>
                            <?php echo $cada_cargahorariatotal['ch']; ?>
                        </td>

                    <?php endif; ?>
                <?php endforeach; ?>

                <td>
                    <?php echo "Total: "; ?>
                </td>

                <td>
                    <?php echo $c_cargahorariatotal['ch_total']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>