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
 * @property string $ajuste2020
 * @property string $turno
 * @property string $nivel
 * @property int $tc
 * @property \Cake\I18n\FrozenDate|null $tc_solicitacao
 * @property int $instituicaoestagio_id
 * @property int|null $supervisor_id
 * @property int|null $professor_id
 * @property string $periodo
 * @property int|null $turmaestagio_id
 * @property string|null $nota
 * @property int|null $ch
 * @property string|null $observacoes
 * @property string|null $complemento_id
 * @property string|null $benetransporte
 * @property string|null $benealimentacao
 * @property string|null $benebolsa 
 * 
 * @property \App\Model\Entity\Aluno[] $alunos
 * @property \App\Model\Entity\Estudante[] $estudantes
 * @property \App\Model\Entity\Instituicaoestagio[] $instituicaoestagios
 * @property \App\Model\Entity\Supervisor[] $supervisores
 * @property \App\Model\Entity\Docente[] $docentes
 * @property \App\Model\Entity\Turmaestagio[] $turmaestagios
 * @property \App\Model\Entity\Avaliacao[] $avaliacoes
 * @property \App\Model\Entity\Folhadeatividade[] $folhadeatividades
 */
class Estagiario extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'aluno_id' => true,
        'estudante_id' => true,
        'registro' => true,
        'ajuste2020' => true,
        'turno' => true,
        'nivel' => true,
        'tc' => true,
        'tc_solicitacao' => true,
        'instituicaoestagio_id' => true,
        'supervisor_id' => true,
        'professor_id' => true,
        'periodo' => true,
        'turmaestagio_id' => true,
        'nota' => true,
        'ch' => true,
        'observacoes' => true,
        'complemento_id' => true,
        'benetransporte' => true,
        'benealimentacao' => true,
        'benebolsa' => true,
        'alunos' => true,
        'estudantes' => true,
        'instituicaoestagios' => true,
        'supervisores' => true,
        'docentes' => true,
        'turmaestagios' => true,
        'avaliacoes' => true,
        'folhadeatividades' => true,
    ];
}
