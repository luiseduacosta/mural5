<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Turno;
use Authorization\IdentityInterface;

/**
 * Turno Policy
 */
class TurnoPolicy
{
    public function canAdd(?IdentityInterface $user, Turno $turno)
    {
        return isset($user) && $user->categoria == 1;
    }

    public function canEdit(?IdentityInterface $user, Turno $turno)
    {
        return isset($user) && $user->categoria == 1;
    }

    public function canDelete(?IdentityInterface $user, Turno $turno)
    {
        return isset($user) && $user->categoria == 1;
    }

    public function canView(?IdentityInterface $user, Turno $turno)
    {
        return isset($user) && $user->categoria == 1;
    }
}
