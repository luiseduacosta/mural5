<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstagiariosTable;
use Authorization\IdentityInterface;

/**
 * Estagiarios policy
 */
class EstagiariosTablePolicy
{
    /**
     * Check if $user can index Estagiarios
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\EstagiariosTable $estagiarios
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, EstagiariosTable $estagiarios)
    {
        return isset($user);
    }

    /**
     * Check if $user can lancanota Estagiarios
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\EstagiariosTable $estagiarios
     * @return bool
     */
    public function canLancanota(?IdentityInterface $user, EstagiariosTable $estagiarios)
    {
        return isset($user) && in_array($user->categoria, ['1', '3']);
    }

    /**
     * Check if $user can lancanotapdf Estagiarios
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\EstagiariosTable $estagiarios
     * @return bool
     */
    public function canLancanotapdf(?IdentityInterface $user, EstagiariosTable $estagiarios)
    {
        return isset($user) && in_array($user->categoria, ['1', '3']);
    }
}
