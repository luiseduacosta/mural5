<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AlunosTable;
use Authorization\IdentityInterface;

/**
 * Alunos policy
 */
class AlunosTablePolicy
{
    /**
     * Check if $user can index Alunos
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AlunosTable $alunos
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, AlunosTable $alunos)
    {

        return isset($user) && ($user->categoria == 1 || $user->categoria == 2);
    }

    /**
     * Check if $user can access planilhaseguro
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AlunosTable $alunos
     * @return bool
     */
    public function canPlanilhaseguro(?IdentityInterface $user, AlunosTable $alunos)
    {
        return isset($user) && $user->categoria == 1; // Admin
    }

    /**
     * Check if $user can access planilhacress
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AlunosTable $alunos
     * @return bool
     */
    public function canPlanilhacress(?IdentityInterface $user, AlunosTable $alunos)
    {
        return isset($user) && $user->categoria == 1; // Admin
    }

    /**
     * Check if $user can access cargahoraria
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Table\AlunosTable $alunos
     * @return bool
     */
    public function canCargahoraria(?IdentityInterface $user, AlunosTable $alunos)
    {
        return isset($user) && $user->categoria == 1; // Admin
    }
}
