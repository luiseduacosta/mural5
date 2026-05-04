<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\QuestoesTable;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * QuestoesTable policy
 */
final class QuestoesTablePolicy implements BeforePolicyInterface
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

    public function canIndex(?IdentityInterface $user, QuestoesTable $questoes): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false);
    }
}
