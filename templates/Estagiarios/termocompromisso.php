<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
declare(strict_types=1);

$user_data = ['categoria' => '0', 'entidade_id' => 0, 'aluno_id' => 0, 'professor_id' => 0, 'supervisor_id' => 0];
$user_session = $this->request->getAttribute('identity');
if ($user_session) {
    $user_data = $user_session->getOriginalData();
}
?>

<script type="text/javascript">
    function getsupervisores(id) {
        $.ajax(
            {
                url: '<?= $this->Url->build(['controller' => 'Instituicoes', 'action' => 'buscasupervisores']) ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    _csrfToken: '<?= $this->request->getAttribute('csrfToken') ?>'
            },
            success: function (response) {
                let options = '<option value="">Selecione o supervisor</option>';
                if (response && Object.keys(response).length > 0) {
                    $.each(response, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                } else {
                    options = '<option value="">Nenhum supervisor encontrado</option>';
                }
                $('#supervisor-id').html(options);
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
                $('#supervisor-id').html('<option value="">Erro ao carregar supervisores</option>');
            }
        }
    );
    }
</script>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light w-75 mx-auto" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
            aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <?php if ($user_data['categoria'] === '1'): ?>
            <li class="nav-item">
                <?=
                $this->Form->postLink('', [''=> $user_data[''],
                        __('Excluir'),
                        ['action' => 'delete', $estagiario->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger me-2', 'style' => 'font-size: 10pt;']
                    ]
                )
                ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary me-2', 'style' => 'font-size: 10pt;']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiario, ['method' => 'post']) ?>
    <fieldset class="border p-2">
        <?php if ($nivel == '9'): ?>
            <legend><?= __('Estágio extra-curricular') ?></legend>
        <?php else: ?>
            <legend><?= __('Termo de compromisso') ?></legend>
        <?php endif; ?>
        <?php
        echo $this->Form->control('aluno_id', ['options' => [$aluno_id => $nomealuno], 'required' => true, 'readonly' => true]);
        echo $this->Form->control('registro', ['label' => 'Registro', 'required' => true, 'readonly' => true]);
        if ($nivel == '9'):
            echo $this->Form->control('nivel', ['label' => false, 'value' => $nivel, 'hidden' => true, 'readonly' => true]);
        else:
            echo $this->Form->control('nivel', ['value' => $nivel, 'readonly' => true]);
        endif;
        echo $this->Form->control('tc_solicitacao', ['default' => date('Y-m-d'), 'label' => 'Data de solicitação', 'readonly' => true]);
        echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo, 'required' => true, 'readonly' => true]);
        echo $this->Form->control('ajuste2020', ['label' => 'Ajuste 2020', 'options' => ['0' => 'Não', '1' => 'Sim'], 'default' => '1']);

        echo $this->Form->control('instituicao_id', ['value' => $instituicao_id, 'options' => $instituicoes, 'required' => true, 'onchange' => 'getsupervisores(this.value)','empty' => 'Seleciona instituição']);

        if (isset($supervisor_id)) {
            echo $this->Form->control('supervisor_id', ['value' => $supervisor_id, 'options' => $supervisores, 'required' => false, 'empty' => "Seleciona supervisor"]);
        } else {
            echo $this->Form->control('supervisor_id', ['options' => $supervisores, 'required' => false, 'empty' => "Seleciona supervisor"]);
        }
        echo $this->Form->control('professor_id', ['options' => $professores, 'required' => false, 'empty' => true]);
        echo $this->Form->control('nota', ['hidden' => true, 'label' => false]);
        echo $this->Form->control('ch', ['hidden' => true, 'label' => false]);
        echo $this->Form->control('observacoes', ['label' => 'Observações', 'type' => 'textarea', 'rows' => 5, 'cols' => 40, 'default' => '', 'required' => false]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar')) ?>
    <?= $this->Form->end() ?>
</div>