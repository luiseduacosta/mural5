<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folhadeatividade Entity
 *
 * @property int $id
 * @property int $estagiario_id
 * @property \Cake\I18n\FrozenDate $dia
 * @property \Cake\I18n\FrozenTime $inicio
 * @property \Cake\I18n\FrozenTime $final
 * @property \Cake\I18n\FrozenTime|null $horario
 * @property string $atividade
 *
 * @property \App\Model\Entity\Estagiario $estagiario
 */
class Folhadeatividade extends Entity
{
    protected array $_accessible = [
        'estagiario_id' => true,
        'dia' => true,
        'inicio' => true,
        'final' => true,
        'atividade' => true,
    ];
}
