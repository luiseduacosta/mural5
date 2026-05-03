<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Turno Entity
 *
 * @property int $id
 * @property string $turno
 *
 * @property \App\Model\Entity\Aluno[] $alunos
 */
class Turno extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'turno' => true,
        'alunos' => true,
    ];
}
