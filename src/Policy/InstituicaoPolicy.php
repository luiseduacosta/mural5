<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Instituicao;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class InstituicaoPolicy implements BeforePolicyInterface
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

            if ($this->isAdmin($user_data)) {
                return true;
            }

            if ($this->isProfessor($user_data) && $action !== 'delete') {
                return true;
            }
        }

        return null;
    }

    /**
     * @param \Authorization\IdentityInterface|null $user
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return \Authorization\Policy\Result
     */
    public function canView(?IdentityInterface $user, Instituicao $instituicao): Result
    {
        return new Result(true);
    }

    /**
     * @param \Authorization\IdentityInterface|null $user
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return \Authorization\Policy\Result
     */
    public function canEdit(?IdentityInterface $user, Instituicao $instituicao): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();
        if ($this->isSupervisorOfInstituicao($user_data, $instituicao)) {
            return new Result(true);
        }

        return new Result(false);
    }

    /**
     * @param \Authorization\IdentityInterface|null $user
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return \Authorization\Policy\Result
     */
    public function canAdd(?IdentityInterface $user, Instituicao $instituicao): Result
    {
        if (!$user) {
            return new Result(false);
        }

        $user_data = $user->getOriginalData();

        return $this->isAdmin($user_data) ? new Result(true) : new Result(false);
    }

    /**
     * @param \Authorization\IdentityInterface|null $user
     * @param \App\Model\Entity\Instituicao $instituicao
     * @return \Authorization\Policy\Result
     */
    public function canDelete(?IdentityInterface $user, Instituicao $instituicao): Result
    {
        return new Result(false);
    }

    private function isAdmin(mixed $user_data): bool
    {
        return ($user_data['categoria'] ?? null) === '1' && !empty($user_data['entidade_id']);
    }

    private function isProfessor(mixed $user_data): bool
    {
        return !empty($user_data['professor_id'] ?? null);
    }

    private function isSupervisorOfInstituicao(mixed $user_data, Instituicao $instituicao): bool
    {
        $supervisor_id = $user_data['supervisor_id'] ?? null;
        if (!$supervisor_id) {
            return false;
        }

        $supervisores = $instituicao->supervisores ?? null;
        if (!$supervisores) {
            return false;
        }

        foreach ($supervisores as $supervisor) {
            if (($supervisor->id ?? null) == $supervisor_id) {
                return true;
            }
        }

        return false;
    }
}
