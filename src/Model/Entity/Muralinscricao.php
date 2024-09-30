<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Muralinscricao Entity
 *
 * @property int $id
 * @property int $registro
 * @property int|null $estudante_id
 * @property int $muralestagio_id
 * @property \Cake\I18n\FrozenDate $data
 * @property string $periodo
 * @property \Cake\I18n\FrozenTime $timestamp
 *
 * @property \App\Model\Entity\Estudante[] $estudantes
 * @property \App\Model\Entity\Muralestagio[] $muralestagios
 */
class Muralinscricao extends Entity
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
    protected array $_accessible = [
        'id_aluno' => true, // registro 
        'aluno_id' => true,
        'alunonovo_id' => true,
        'id_instituicao' => true, // id atual do mural de estagios
        'data' => true,
        'periodo' => true,
        'timestamp' => true,
        'estudantes' => true,
        'muralestagios' => true,
    ];
}
