<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Resposta;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * Resposta policy
 */
final class RespostaPolicy implements BeforePolicyInterface
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
     * Check if $user can add Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return \Authorization\Policy\Result
     */
    public function canAdd(?IdentityInterface $user, Resposta $resposta): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && in_array($user_data['categoria'], ['1', '2'], true)
            ? new Result(true)
            : new Result(false, 'Erro: resposta add policy not authorized');
    }

    /**
     * Check if $user can edit Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return \Authorization\Policy\Result
     */
    public function canEdit(?IdentityInterface $user, Resposta $resposta): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return $user_data && in_array($user_data['categoria'], ['1', '2'], true)
            ? new Result(true)
            : new Result(false, 'Erro: resposta edit policy not authorized');
    }

    /**
     * Check if $user can delete Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return \Authorization\Policy\Result
     */
    public function canDelete(?IdentityInterface $user, Resposta $resposta): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return isset($user_data['categoria']) && in_array($user_data['categoria'], ['1', '2'], true)
            ? new Result(true)
            : new Result(false, 'Erro: resposta delete policy not authorized');
    }

    /**
     * Check if $user can view Resposta
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Resposta $resposta
     * @return \Authorization\Policy\Result
     */
    public function canView(?IdentityInterface $user, Resposta $resposta): Result
    {
        if (!$user) {
            return new Result(false);
        }

        return new Result(true);
    }
}
