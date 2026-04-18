<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Administrador;
use Authorization\IdentityInterface;

/**
 * Administrador Policy
 */
class AdministradorPolicy
{
    /**
     * Check if $user can add Administrador
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Administrador $administrador
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Administrador $administrador)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Administrador
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Administrador $administrador
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Administrador $administrador)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Administrador
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Administrador $administrador
     * @return bool
     */
    public function canView(?IdentityInterface $user, Administrador $administrador)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Administrador
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Administrador $administrador
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Administrador $administrador)
    {
        return isset($user) && $user->categoria == '1';
    }
}
