<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Categoria;
use Authorization\IdentityInterface;

/**
 * Categoria Policy
 */
class CategoriaPolicy
{
    /**
     * Check if $user can add Categoria
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Categoria $categoria
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Categoria $categoria)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can edit Categoria
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Categoria $categoria
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Categoria $categoria)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can view Categoria
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Categoria $categoria
     * @return bool
     */
    public function canView(?IdentityInterface $user, Categoria $categoria)
    {
        return isset($user) && $user->categoria == '1';
    }

    /**
     * Check if $user can delete Categoria
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Categoria $categoria
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Categoria $categoria)
    {
        return isset($user) && $user->categoria == '1';
    }
}
