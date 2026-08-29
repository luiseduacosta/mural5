<?php
declare(strict_types=1);

namespace App\Policy;

use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;
use Cake\ORM\Query;

final class UsersTablePolicy implements BeforePolicyInterface
{
    /**
     * @param IdentityInterface|null $identity
     * @param mixed $resource
     * @param string $action
     * @return ResultInterface|bool|null
     */
    public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
    {
        if ($identity) {
            $user_data = $identity->getOriginalData();

            if (isset($user_data['categoria']) && $user_data['categoria'] === '1') {
                return true;
            }
        }

        return null;
    }

    /**
     * @param IdentityInterface $user
     * @param Query $query
     * @return Query
     */
    public function scopeIndex(IdentityInterface $user, Query $query): Query
    {
        $user_data = $user->getOriginalData();

        if (!isset($user_data['categoria']) || $user_data['categoria'] !== '1') {
            if (!($user_data instanceof \ArrayAccess || is_array($user_data)) || empty($user_data['id'])) {
                return $query->where(['Users.id' => 0]);
            }

            return $query->where(['Users.id' => $user_data['id']]);
        }

        return $query;
    }
}
