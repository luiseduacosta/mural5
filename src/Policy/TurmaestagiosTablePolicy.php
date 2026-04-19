<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\TurmaestagiosTable;
use Authorization\IdentityInterface;

/**
 * Turmaestagios Table Policy
 */
class TurmaestagiosTablePolicy
{
    /**
     * Check if $user can index Turmaestagios
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\TurmaestagiosTable $turmaestagios
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, TurmaestagiosTable $turmaestagios)
    {
        return isset($user) && $user->categoria == 1;
    }
}
