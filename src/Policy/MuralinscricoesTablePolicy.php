<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\MuralinscricoesTable;
use Authorization\IdentityInterface;

/**
 * Muralinscricoes policy
 */
class MuralinscricoesTablePolicy
{
    public function canIndex(?IdentityInterface $user, MuralinscricoesTable $muralinscricoes)
    {
        return isset($user) && ($user->categoria == 1 || $user->categoria == 2);
    }
}
