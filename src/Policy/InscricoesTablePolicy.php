<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\InscricoesTable;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\ORM\Query;

final class InscricoesTablePolicy implements BeforePolicyInterface
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

            if (
                isset($user_data['categoria'])
                && (
                    ($user_data['categoria'] === '1')
                    || $user_data['aluno_id']
                )
            ) {
                return true;
            }
        }

        return null;
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Table\InscricoesTable $inscricoesTable
     * @return \Authorization\Policy\Result
     */
    public function canIndex(IdentityInterface $userSession, InscricoesTable $inscricoesTable): Result
    {
        return new Result(true);
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
            return $query->where(['Inscricoes.aluno_id' => $user_data['aluno_id']]);
        }

        return $query->where(['Inscricoes.id' => 0]);
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Table\InscricoesTable $inscricoesTable
     * @return \Authorization\Policy\Result
     */
    public function canAdd(IdentityInterface $userSession, InscricoesTable $inscricoesTable): Result
    {
        $user_data = $userSession->getOriginalData();
        if (isset($user_data['categoria']) && $user_data['categoria'] === '1') {
            return new Result(true);
        }

        return !empty($user_data['aluno_id'])
            ? new Result(true)
            : new Result(false, 'Erro: inscricoes canAdd policy not authorized');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canBusca(?IdentityInterface $user, $resource): Result
    {
        return new Result(false, 'Erro: inscricoes busca policy not authorized');
    }
}
