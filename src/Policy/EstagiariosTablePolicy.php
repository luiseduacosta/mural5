<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstagiariosTable;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\ORM\Query;

final class EstagiariosTablePolicy implements BeforePolicyInterface
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
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Table\EstagiariosTable $estagiariosTable
     * @return \Authorization\Policy\Result
     */
    public function canIndex(IdentityInterface $userSession, EstagiariosTable $estagiariosTable): Result
    {
        return new Result(true);
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Table\EstagiariosTable $estagiariosTable
     * @return \Authorization\Policy\Result
     */
    public function canLancanota(IdentityInterface $userSession, EstagiariosTable $estagiariosTable): Result
    {
        $user_data = $userSession->getOriginalData();
        if (!empty($user_data['professor_id'])) {
            return new Result(true);
        }
        if (isset($user_data['categoria']) && $user_data['categoria'] === '1') {
            return new Result(true);
        }

        return new Result(false, 'Erro: lancanota policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Table\EstagiariosTable $estagiariosTable
     * @return \Authorization\Policy\Result
     */
    public function canLancanotapdf(IdentityInterface $userSession, EstagiariosTable $estagiariosTable): Result
    {
        $user_data = $userSession->getOriginalData();
        if ($user_data['professor_id']) {
            return new Result(true);
        }

        return new Result(false, 'Erro: lancanota policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $user
     * @param \Cake\ORM\Query $query
     * @return \Cake\ORM\Query
     */
    public function scopeIndex(IdentityInterface $user, Query $query): Query
    {
        $user_data = $user->getOriginalData();

        if (isset($user_data['categoria']) && $user_data['categoria'] === '1') {
            return $query;
        }

        if (!empty($user_data['aluno_id'])) {
            return $query->where(['Estagiarios.aluno_id' => $user_data['aluno_id']]);
        }

        if (!empty($user_data['professor_id'])) {
            return $query->where(['Estagiarios.professor_id' => $user_data['professor_id']]);
        }

        if (!empty($user_data['supervisor_id'])) {
            return $query->where(['Estagiarios.supervisor_id' => $user_data['supervisor_id']]);
        }

        return $query->where(['Estagiarios.id' => 0]);
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canBusca(?IdentityInterface $user, $resource): Result
    {
        return new Result(false, 'Erro: estagiarios busca policy not authorized');
    }
}
