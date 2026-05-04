<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\RespostasTable;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * RespostasTable policy
 */
final class RespostasTablePolicy implements BeforePolicyInterface
{
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

    public function canIndex(?IdentityInterface $user, RespostasTable $respostas): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return $user_data && isset($user_data['categoria']) && in_array($user_data['categoria'], ['1', '2'], true)
            ? new Result(true)
            : new Result(false);
    }
}
