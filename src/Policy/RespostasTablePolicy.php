<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\RespostasTable;
use Authorization\IdentityInterface;

/**
 * RespostasTable policy
 */
class RespostasTablePolicy
{
    /**
     * Check if $user can index Respostas
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\RespostasTable $respostas
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, RespostasTable $respostas)
    {
        if ($user) {
            $user_data = $user->getOriginalData();

            if (isset($user_data['categoria']) && in_array($user_data['categoria'], [1, 2])) {
                return true;
            }
        }

        return false;
    }
}
