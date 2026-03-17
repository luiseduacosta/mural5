<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AdministradoresTable;
use Authorization\IdentityInterface;

/**
 * Administradores Table Policy
 */
class AdministradoresTablePolicy
{
    /**
     * Check if $user can index Administradores
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AdministradoresTable $administradores
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, AdministradoresTable $administradores)
    {
        return isset($user) && $user->categoria == '1';
    }
}
