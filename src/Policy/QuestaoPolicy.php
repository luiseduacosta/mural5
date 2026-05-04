<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Questao;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * Questao policy
 */
final class QuestaoPolicy implements BeforePolicyInterface
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
     * Check if $user can add Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return \Authorization\Policy\Result
     */
    public function canAdd(?IdentityInterface $user, Questao $questao): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false, 'Erro: questao add policy not authorized');
    }

    /**
     * Check if $user can edit Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return \Authorization\Policy\Result
     */
    public function canEdit(?IdentityInterface $user, Questao $questao): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false, 'Erro: questao edit policy not authorized');
    }

    /**
     * Check if $user can delete Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return \Authorization\Policy\Result
     */
    public function canDelete(?IdentityInterface $user, Questao $questao): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && $user_data['categoria'] === '1'
            ? new Result(true)
            : new Result(false, 'Erro: questao delete policy not authorized');
    }

    /**
     * Check if $user can view Questao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Questao $questao
     * @return \Authorization\Policy\Result
     */
    public function canView(?IdentityInterface $user, Questao $questao): Result
    {
        return $user ? new Result(true) : new Result(false);
    }
}
