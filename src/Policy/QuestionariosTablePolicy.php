<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\QuestionariosTable;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * QuestionariosTable policy
 */
final class QuestionariosTablePolicy implements BeforePolicyInterface
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

    public function canIndex(?IdentityInterface $user, QuestionariosTable $questionarios): Result
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
