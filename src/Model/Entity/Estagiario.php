<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estagiario Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property int|null $estudante_id
 * @property int $registro
 * @property string $ajustecurricular2020
 * @property string $turno
 * @property string $nivel
 * @property int $tc
 * @property \Cake\I18n\FrozenDate|null $tc_solicitacao
 * @property int $instituicaoestagio_id
 * @property int|null $supervisor_id
 * @property int|null $docente_id
 * @property string $periodo
 * @property int|null $areaestagio_id
 * @property string|null $nota
 * @property int|null $ch
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Estudante $estudante
 * @property \App\Model\Entity\Instituicaoestagio $instituicaoestagio
 * @property \App\Model\Entity\Supervisor $supervisor
 * @property \App\Model\Entity\Docente $docente
 * @property \App\Model\Entity\Areaestagio $areaestagio
 */
class Estagiario extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id_aluno' => true,
        'alunonovo_id' => true,
        'registro' => true,
        'ajustecurricular2020' => true,
        'turno' => true,
        'nivel' => true,
        'tc' => true,
        'tc_solicitacao' => true,
        'id_instituicao' => true,
        'id_supervisor' => true,
        'id_professor' => true,
        'periodo' => true,
        'id_area' => true,
        'nota' => true,
        'ch' => true,
        'observacoes' => true,
        'complemento_id' => true,
        'aluno' => true,
        'estudante' => true,
        'instituicaoestagio' => true,
        'supervisor' => true,
        'docente' => true,
        'areaestagio' => true,
    ];
}
