<?php // pr($t_seguro);       ?>
<?php // pr($periodos);       ?>
<?php // pr($periodoselecionado);       ?>
<?php // die();       ?>

<script>

    var base_url = "<?= $this->Html->Url->build(['controller' => 'Alunos', 'action' => 'planilhaseguro']); ?>";
    /* alert(base_url); */

    $(document).ready(function () {

        $("#periodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "?periodo=" + periodo;
        })
    });

</script>

<?= $this->element('templates') ?>

<div class="container">
    <div class='table-responsive'>

        <?= $this->Form->create(null, ['url' => 'index'], ['class' => 'form-inline']); ?>
        <?= $this->Form->input('periodo', ['id' => 'periodo', 'type' => 'select', 'label' => ['style' => 'display:inline;'], 'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => array($periodoselecionado => 'Período'), 'class' => 'form-control']); ?>
        <?= $this->Form->end(); ?>

        <table class='table table-striped table-hover table-responsive'>
            <thead class='thead-light'>
            <caption style='caption-side: top'>Planilha para seguro de vida dos alunos estagiários</caption>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Nascimento</th>
                <th>Sexo</th>
                <th>DRE</th>
                <th>Curso</th>
                <th>Nível</th>
                <th>Período</th>
                <th>Início</th>
                <th>Final</th>
                <th>Instituição</th>
            </tr>
            </thead>
            <?php foreach ($t_seguro as $cada_aluno): ?>
                <?php // pr($cada_aluno);  ?>
                <?php // die(); ?>
                <tr>
                    <td>
                        <?php echo $this->Html->link($cada_aluno['nome'], '/alunos/view/' . $cada_aluno['id']); ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['cpf']; ?>
                    </td>
                    <td>
                        <?php if (empty($cada_aluno['nascimento'])): ?>
                            <?php echo "s/d"; ?>
                        <?php else: ?>
                            <?php echo date('d-m-Y', strtotime($cada_aluno['nascimento'])); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['sexo']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['registro']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['curso']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['nivel']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['periodo']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['inicio']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['final']; ?>
                    </td>
                    <td>
                        <?php echo $cada_aluno['instituicao']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>