<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Supervisor;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class SupervisorPolicy implements BeforePolicyInterface
{
    /**
     * @param \Authorization\IdentityInterface|null $identity
     * @param mixed $resource
     * @param string $action
     * @return \Authorization\Policy\ResultInterface|bool|null
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
     * @param \Authorization\IdentityInterface|null $user
     * @param \App\Model\Entity\Supervisor $supervisor
     * @return \Authorization\Policy\Result
     */
    public function canAdd(?IdentityInterface $user, Supervisor $supervisor): Result
    {
        if (!$user) {
            return new Result(false, 'Erro: usuário não autenticado');
        }

        $user_data = $user->getOriginalData();

        if (isset($user_data['categoria']) && in_array($user_data['categoria'], ['1', '4'])) {
            return new Result(true);
        }
        return new Result(false, 'Erro: supervisor add policy not allowed');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canView(?IdentityInterface $user, $resource): Result
    {
        if (!$user) {
            return new Result(false, 'Not authorized');
        }
        return new Result(true);
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Supervisor $userData
     * @return \Authorization\Policy\Result
     */
    public function canEdit(IdentityInterface $userSession, Supervisor $supervisorData): Result
    {
        return $this->sameUser($userSession, $supervisorData)
            ? new Result(true)
            : new Result(false, 'Erro: supervisor edit policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Supervisor $supervisorData
     * @return \Authorization\Policy\Result
     */
    public function canDelete(IdentityInterface $userSession, Supervisor $supervisorData): Result
    {
        return new Result(false, 'Erro: supervisor delete policy not allowed');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Supervisor $supervisorData
     * @return bool
     */
    protected function sameUser(IdentityInterface $userSession, Supervisor $supervisorData): bool
    {
        return (int)$userSession->getIdentifier() === (int)$supervisorData->user_id;
    }
}
