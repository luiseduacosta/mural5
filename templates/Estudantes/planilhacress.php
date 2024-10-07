<?php
// pr($cress);
// pr($periodos);
// pr($periodoselecionado);
// die();
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->Url->build(['controller' => 'estudantes', 'action' => 'planilhacress']); ?>";
        /* alert(base_url); */

        $("#EstudantesPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = base_url + "?periodo=" + periodo;
        })
    });

</script>

<?= $this->element('templates') ?>

<div class='container'>
    <div class='table-responsive'>
        <p>Período</p>
        <?php echo $this->Form->create(null, ['class' => 'form-inline']); ?>
        <?php echo $this->Form->input('periodo', ['type' => 'select', 'id' => 'EstudantesPeriodo', 'label' => ['text' => 'Período'], 'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => [$periodoselecionado => $periodoselecionado]], ['class' => 'form-control']); ?>
        <?php echo $this->Form->end(); ?>
    </div>

    <table class='table table-hover table-striped table-responsive'>
        <caption style='caption-side: top;'>Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª Região</caption>
        <thead class='thead-light'>
            <tr>
                <th>Estudante</th>
                <th>Instituição</th>
                <th>Endereço</th>
                <th>CEP</th>
                <th>Bairro</th>
                <th>Supervisor</th>
                <th>CRESS</th>
                <th>Professor</th>
            </tr>
        </thead>
        <?php foreach ($cress as $c_cress): ?>
            <?php // pr($c_cress); ?>
            <tr>
                <td><?php echo isset($c_cress->estudante->nome) ? $this->Html->link($c_cress->estudante->nome, '/estudantes/view/' . $c_cress->estudante->id) : 'Sem informação'; ?></td>
                <td><?php echo isset($c_cress->instituicaoestagio->instituicao) ? $this->Html->link($c_cress->instituicaoestagio->instituicao, '/instituicaoestagios/view/' . $c_cress->instituicaoestagio->id) : 'Sem informação'; ?></td>
                <td><?php echo $c_cress->instituicaoestagio->endereco; ?></td>
                <td><?php echo isset($c_cress->instituicaoestagio->cep) ? $c_cress->instituicaoestagio->cep : ''; ?></td>
                <td><?php echo isset($c_cress->instituicaoestagio->bairro) ? $c_cress->instituicaoestagio->bairro : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->nome) ? $c_cress->supervisor->nome : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->cress) ? $c_cress->supervisor->cress : ''; ?></td>
                <td><?php echo isset($c_cress->professor->nome) ? $c_cress->professor->nome : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>