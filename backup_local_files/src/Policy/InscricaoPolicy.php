<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Inscricao;
use Authorization\IdentityInterface;

/**
 * Inscricao policy
 */
class InscricaoPolicy
{
    /**
     * Check if $user can add Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Inscricao $inscricao)
    {
        return isset($user->categoria) && ($user->categoria == 1 || $user->categoria == 2);
    }

    /**
     * Check if $user can edit Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Inscricao $inscricao)
    {
        return isset($user->categoria) && $user->categoria == 1;
    }

    /**
     * Check if $user can delete Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Inscricao $inscricao)
    {
        if (isset($user->categoria) && $user->categoria == 1) {
            return true;
        } elseif (isset($user->categoria) && $user->categoria == 2) {
            return $inscricao->aluno_id == $user->aluno_id;
        }
        return false;
    }

    /**
     * Check if $user can view Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Inscricao $inscricao)
    {
        return isset($user->categoria) && ($user->categoria == 1 || $user->categoria == 2);
    }
}
