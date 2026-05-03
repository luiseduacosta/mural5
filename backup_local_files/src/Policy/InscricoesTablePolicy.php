<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\InscricoesTable;
use Authorization\IdentityInterface;

/**
 * Inscricoes policy
 */
class InscricoesTablePolicy
{
    public function canIndex(?IdentityInterface $user, InscricoesTable $inscricoes)
    {
        return isset($user->categoria) && ($user->categoria == 1 || $user->categoria == 2);
    }
}
