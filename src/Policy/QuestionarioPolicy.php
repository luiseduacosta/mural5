<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Questionario;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * Questionario policy
 */
final class QuestionarioPolicy implements BeforePolicyInterface
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

    /**
     * Check if $user can add questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return \Authorization\Policy\Result
     */
    public function canAdd(?IdentityInterface $user, Questionario $questionario): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false, 'Erro: questionario add policy not authorized');
    }

    /**
     * Check if $user can edit questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return \Authorization\Policy\Result
     */
    public function canEdit(?IdentityInterface $user, Questionario $questionario): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false, 'Erro: questionario edit policy not authorized');
    }

    /**
     * Check if $user can delete questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return \Authorization\Policy\Result
     */
    public function canDelete(?IdentityInterface $user, Questionario $questionario): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false, 'Erro: questionario delete policy not authorized');
    }

    /**
     * Check if $user can view questionario
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\questionario $questionario
     * @return \Authorization\Policy\Result
     */
    public function canView(?IdentityInterface $user, Questionario $questionario): Result
    {
        return $user ? new Result(true) : new Result(false);
    }
}
