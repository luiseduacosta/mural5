<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Turno;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class TurnoPolicy implements BeforePolicyInterface
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
     * @return \Authorization\Policy\Result
     */
    public function canAdd(?IdentityInterface $user, $resource): Result
    {
        return new Result(false, 'Erro: turno add policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Turno $turno
     * @return \Authorization\Policy\Result
     */
    public function canView(IdentityInterface $user, Turno $turno): Result
    {
        return new Result(true);
    }

    /**
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Turno $turno
     * @return \Authorization\Policy\Result
     */
    public function canEdit(IdentityInterface $user, Turno $turno): Result
    {
        if ($user) {
            $user_data = $user->getOriginalData();

            if (isset($user_data['categoria']) && $user_data['categoria'] === '1') {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Turno $turno
     * @return \Authorization\Policy\Result
     */
    public function canDelete(IdentityInterface $user, Turno $turno): Result
    {
        if ($user) {
            $user_data = $user->getOriginalData();

            if (isset($user_data['categoria']) && $user_data['categoria'] === '1') {
                return true;
            }
        }

        return false;
    }
}
