<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Area;
use Authorization\IdentityInterface;

/**
 * Area policy
 */
class AreaPolicy
{
    /**
     * Check if $user can add Area
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Area $area
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Area $area)
    {
        return isset($user) && $user->categoria == 1;
    }

    /**
     * Check if $user can edit Area
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Area $area
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Area $area)
    {
        return isset($user) && $user->categoria == 1;
    }

    /**
     * Check if $user can delete Area
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Area $area
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Area $area)
    {
        return isset($user) && $user->categoria == 1;
    }

    /**
     * Check if $user can view Area
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Area $area
     * @return bool
     */
    public function canView(?IdentityInterface $user, Area $area)
    {
        return isset($user) && $user->categoria == 1;
    }
}
