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
        if (isset($user) && $user->categoria === '1') {
            return true;
        } elseif (isset($user) && $user->categoria === '2') {
            return true;
        }
        return false;
    }
}
