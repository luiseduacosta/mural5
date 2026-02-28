<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\questao;
use Authorization\IdentityInterface;

/**
 * Questao policy
 */
class QuestaoPolicy
{
    /**
     * Check if $user can add Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Questao $questao)
    {
        if (isset($user) && $user->categoria === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can edit Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Questao $questao)
    {
        if (isset($user) && $user->categoria === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can delete Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Questao $questao)
    {
        if (isset($user) && $user->categoria === '1') {
            return true;
        }
        return false;
    }

    /**
     * Check if $user can view Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Questao $questao)
    {
        if (isset($user)) {
            return true;
        }
        return false;
    }
}
