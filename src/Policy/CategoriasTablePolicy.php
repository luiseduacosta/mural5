<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\CategoriasTable;
use Authorization\IdentityInterface;

/**
 * Categoria Policy
 */
class CategoriasTablePolicy
{
    /**
     * Check if $user can index Categorias
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Table\CategoriasTable $categoria
     * @return bool
     */
    public function canIndex(?IdentityInterface $user, CategoriasTable $categoria)
    {
        return isset($user) && $user->categoria == '1';
    }
}
