<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Avaliacao Entity
 *
 * @property int $id
 * @property int $estagiario_id
 * @property string|null $avaliacao1
 * @property string|null $avaliacao2
 * @property string|null $avaliacao3
 * @property string|null $avaliacao4
 * @property string|null $avaliacao5
 * @property string|null $avaliacao6
 * @property string|null $avaliacao7
 * @property string|null $avaliacao8
 * @property string|null $avaliacao9
 * @property string|null $avaliacao10
 * @property string|null $avaliacao11
 * @property string|null $avaliacao12
 * @property string|null $avaliacao13
 * @property string|null $avaliacao14
 * @property string|null $avaliacao15
 * @property string|null $avaliacao16
 * @property string|null $avaliacao17
 * @property string|null $avaliacao18
 * @property string|null $avaliacao19
 * @property string|null $observacoes
 * @property \Cake\I18n\FrozenTime $TIMESTAMP
 *
 * @property \App\Model\Entity\Estagiario[] $estagiario
 */
class Avaliacao extends Entity {

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
        'estagiario_id' => true,
        'avaliacao1' => true,
        'avaliacao2' => true,
        'avaliacao3' => true,
        'avaliacao4' => true,
        'avaliacao5' => true,
        'avaliacao6' => true,
        'avaliacao7' => true,
        'avaliacao8' => true,
        'avaliacao9' => true,
        'avaliacao10' => true,
        'avaliacao11' => true,
        'avaliacao12' => true,
        'avaliacao13' => true,
        'avaliacao14' => true,
        'avaliacao15' => true,
        'avaliacao16' => true,
        'avaliacao17' => true,
        'avaliacao18' => true,
        'avaliacao19' => true,
        'observacoes' => true,
        'TIMESTAMP' => true,        
        'estagiario' => true,
    ];
}
