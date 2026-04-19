<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\TurnosTable;
use Authorization\IdentityInterface;

/**
 * Turnos Table Policy
 */
class TurnosTablePolicy
{
    /**
     * Check if $user can index Turnos
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\TurnosTable $turnos
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, TurnosTable $turnos)
    {
        return isset($user) && $user->categoria == 1;
    }
}
