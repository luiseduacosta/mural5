<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Folhadeatividade;
use Authorization\IdentityInterface;

/**
 * Folhadeatividade policy
 */
class FolhadeatividadePolicy
{
    /**
     * Check if $user can add Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Folhadeatividade $folhadeatividade)
    {
        return isset($user) && ($user->categoria == '1' || $user->categoria == '2');
    }

    /**
     * Check if $user can edit Folhadeatividade
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Folhadeatividade $folhadeatividade)
    {
        if (!isset($user)) {
            return false;
        }
        if ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '2') {
            // Check if the student owns this activity through their estagiario record
            return isset($user->aluno_id) && $folhadeatividade->estagiario && $folhadeatividade->estagiario->aluno_id == $user->aluno_id;
        }
        return false;
    }

    /**
     * Check if $user can delete Folhadeatividade
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Folhadeatividade $folhadeatividade)
    {
        if (!isset($user)) {
            return false;
        }
        if ($user->categoria == '1') {
            return true;
        } elseif ($user->categoria == '2') {
            // Check if the student owns this activity through their estagiario record
            return isset($user->aluno_id) && $folhadeatividade->estagiario && $folhadeatividade->estagiario->aluno_id == $user->aluno_id;
        }
        return false;
    }

    /**
     * Check if $user can view Folhadeatividade
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canView(?IdentityInterface $user, Folhadeatividade $folhadeatividade)
    {
        return isset($user);
    }

    /**
     * Check if $user can folhadeatividades pdf
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    public function canFolhaDeAtividadePdf(?IdentityInterface $user, Folhadeatividade $folhadeatividade)
    {
        return isset($user) && ($user->categoria == '1' || $user->categoria == '2');
    }
}
