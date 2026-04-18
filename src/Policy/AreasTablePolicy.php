<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AreasTable;
use Authorization\IdentityInterface;

/**
 * Areas policy
 */
class AreasTablePolicy
{
    /**
     * Check if $user can index Areas
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AreasTable $areas
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, AreasTable $areas)
    {
        return isset($user) && $user->categoria == 1;
    }
}
