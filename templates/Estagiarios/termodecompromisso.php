<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
if (isset($estudanteestagiario)) {
    // pr($estudanteestagiario);
} else {
    // echo "Estudante sem estágios." . "<br>";
}
if (isset($ultimoestagio)) {
    // pr($ultimoestagio);
} else {
    // echo "Estudante sem último estágio" . "<br>";
}

if (isset($estudante_semestagio)) {
    // pr($estudante_semestagio);
} else {
    // echo "Estudante estagiário." . "<br>";
}

if (isset($atualizar)) {
    // pr($atualizar);
}

if (isset($instituicaoestagios)) {
    // pr($instituicaoestagios);
}

if (isset($supervisores)) {
    // pr($supervisores);
}
// pr($periodo);
// die();
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'termodecompromisso', '?' => ['estudante_id' => $estudante_id]]); ?>";
        // alert(url);
        $("#instituicaoestagio-id").change(function () {
           var instituicao = $(this).val();
           // alert(instituicao);
            window.location = url + '&instituicao_id=' + instituicao;
        })

    })
</script>

<?= $this->element('templates') ?>

<?php
$submit = [
    "button" => "<div class='d-flex justify-content-center'><button type ='submit' class= 'btn btn-danger' {{attrs}}>{{text}}</button></div>"
]
    ?>

<?php if ((isset($ultimoestagio) && $ultimoestagio) || (isset($estudante_semestagio) && $estudante_semestagio)): ?>
    <div class="row">
        <div class="container">
            <?= $this->Form->create(null, ['type' => 'post']) ?>
            <fieldset>
                <legend><?= __('Solicitação de termo de compromisso') ?></legend>
                <?php
                if (isset($atualizar)) {
                    echo $this->Form->control('id', ['value' => $ultimoestagio->id, 'type' => 'hidden', 'readonly']);
                }
                // Estudante estagiário
                if (isset($ultimoestagio) && $ultimoestagio):
                    echo "<fieldset>";
                    echo "<legend>Estagiário</legend>";
                    echo $this->Form->control('registro', ['value' => $ultimoestagio->estudante->registro, 'readonly']);
                    echo $this->Form->control('estudante_id', ['label' => ['text' => 'Estudante'], 'options' => [$ultimoestagio->estudante->id => $ultimoestagio->estudante->nome], 'empty' => false, 'readonly']);
                    echo $this->Form->control('aluno_id', ['label' => ['text' => 'Aluno'], 'options' => [$ultimoestagio->aluno->id => $ultimoestagio->aluno->nome], 'readonly']);
                    echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                    echo $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso'], 'value' => $ultimoestagio->estudante->ingresso]);
                    echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'value' => substr($ultimoestagio->estudante->turno, 0, 1)]);
                    echo $this->Form->control('nivel', ['value' => $ultimoestagio->nivel]);
                    echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
                    echo "</fieldset>";
                    // Estudante novo sem estágio
                else:
                    echo "<fieldset>";
                    echo "<legend>Estudante sem estágio</legend>";
                    echo $this->Form->control('registro', ['value' => $estudante_semestagio->registro, 'readonly']);
                    echo $this->Form->control('estudante_id', ['label' => ['text' => 'Estudante'], 'options' => [$estudante_semestagio->id => $estudante_semestagio->nome], 'empty' => false, 'readonly']);
                    echo $this->Form->control('aluno_id', ['label' => ['text' => 'Aluno'], 'value' => null, 'type' => 'hidden']);
                    echo $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
                    echo $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso'], 'value' => $estudante_semestagio->ingresso]);
                    echo $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'value' => substr($estudante_semestagio->turno, 0, 1)]);
                    echo $this->Form->control('nivel', ['value' => 1, 'readonly']);
                    echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
                    echo "</fieldset>";
                endif;
                echo $this->Form->control('tc', ['value' => 1]);
                echo $this->Form->control('tc_solicitacao', ['value' => date('Y-m-d')]);
                echo $this->Form->control('tipo_de_estagio', ['label' => ['text' => 'Tipo de estágio'], 'options' => ['1' => 'Presencial', '2' => 'Remoto'], 'default' => '1']);

                if (isset($instituicao_id)) {
                    echo $this->Form->control('instituicaoestagio_id', ['label' => ['text' => 'Instituição1'], 'options' => $instituicaoestagios, 'value' => $instituicao_id, 'required']);
                } elseif (isset($ultimoestagio->instituicaoestagio->id) && $ultimoestagio->instituicaoestagio->id) {
                    echo $this->Form->control('instituicaoestagio_id', ['label' => ['text' => 'Instituição2'], 'options' => $instituicaoestagios, 'empty' => [$ultimoestagio->instituicaoestagio->id => $ultimoestagio->instituicaoestagio->instituicao], 'required']);
                } else {
                    echo $this->Form->control('instituicaoestagio_id', ['label' => ['text' => 'Instituição3'], 'options' => $instituicaoestagios, 'empty' => ['Seleciona instituição de estágio'], 'required']);
                }

                if (isset($ultimoestagio->supervisor->id) && $ultimoestagio->supervisor->id):
                    if (isset($supervisoresdainstituicao) && ($supervisoresdainstituicao)) {
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'value' => $ultimoestagio->supervisor->id, 'empty' => "Selecione supervisor(a)"]);
                        // echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => [$ultimoestagio->supervisor->id => $ultimoestagio->supervisor->nome]]);
                    } else {
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => ['0' => 'Sem informação'], 'value' => $ultimoestagio->supervisor->id, 'empty' => "Selecione supervisor(a)"]);
                    }
                else:
                    if (isset($supervisoresdainstituicao)):
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'empty' => "Selecione supervisor(a)"]);
                    else:
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => ['0' => 'Sem informação'], 'empty' => ['0' => 'Sem informação']]);
                    endif;
                endif;
                ?>
            </fieldset>
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group" aria-label="Confirma">
                    <?php if (isset($ultimoestagio) && $ultimoestagio->id): ?>
                        <?= $this->Html->link('Imprime PDF', ['action' => 'termodecompromissopdf', $ultimoestagio->id], ['class' => 'btn btn-lg btn-primary', 'rule' => 'button', 'style' => 'width: 200px']); ?>
                    <?php endif; ?>
                    <?php $this->Form->setTemplates($submit); ?>
                    <?= $this->Form->button(__('Confirmar alteraçoes antes de imprimir'), ['type' => 'submit', 'class' => 'btn btn-lg btn-danger btn-xs col-lg-3', 'style' => "max-width:200px; word-wrap:break-word;" ]) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>