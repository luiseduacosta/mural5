<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\MuralestagiosTable;
use Authorization\IdentityInterface;

/**
 * Muralestagios Table Policy
 */
class MuralestagiosTablePolicy
{
    /**
     * Anyone (including unauthenticated visitors) can view the mural index.
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\MuralestagiosTable $muralestagios
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, MuralestagiosTable $muralestagios): bool
    {
        return true;
    }

    /**
     * Only admins can add mural entries.
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\MuralestagiosTable $muralestagios
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, MuralestagiosTable $muralestagios): bool
    {
        return isset($user) && $user->categoria == '1';
    }
}
