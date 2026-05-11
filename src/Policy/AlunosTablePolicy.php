<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AlunosTable;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\ORM\Query;

final class AlunosTablePolicy implements BeforePolicyInterface
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
     * @param \App\Model\Table\AlunosTable $alunosTable
     * @return \Authorization\Policy\Result
     */
    public function canIndex(IdentityInterface $userSession, AlunosTable $alunosTable): Result
    {
        $user_data = $userSession->getOriginalData();

        return $user_data && in_array($user_data['categoria'], ['1', '2', '3', '4'])
            ? new Result(true)
            : new Result(false, 'Erro: alunos index policy not authorized');
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

        if (!is_array($user_data) || empty($user_data['id'])) {
            return $query->where(['Alunos.id' => 0]);
        }

        return $query->where(['Alunos.user_id' => $user_data['id']]);
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Table\AlunosTable $alunosTable
     * @return \Authorization\Policy\Result
     */
    public function canAdd(IdentityInterface $userSession, AlunosTable $alunosTable): Result
    {
        $user_data = $userSession->getOriginalData();

        return $user_data && in_array($user_data['categoria'], ['1', '2'])
            ? new Result(true)
            : new Result(false, 'Erro: alunos add policy not authorized');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canBusca(IdentityInterface $userSession, AlunosTable $alunosTable): Result
    {
        $user_data = $userSession->getOriginalData();

        return $user_data && in_array($user_data['categoria'], ['1', '2', '3', '4'])
            ? new Result(true)
            : new Result(false, 'Erro: alunos busca policy not authorized');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canPlanilhacress(?IdentityInterface $user, $resource): Result
    {
        return new Result(false, 'Erro: alunos planilha cress policy not authorized');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canPlanilhaseguro(?IdentityInterface $user, $resource): Result
    {
        return new Result(false, 'Erro: alunos planilha seguro policy not authorized');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canCargahoraria(?IdentityInterface $user, $resource): Result
    {
        return new Result(false, 'Erro: alunos cargahoraria policy not authorized');
    }

    /**
     * @return \Authorization\Policy\Result
     */
    public function canDeclaracaoperiodo(IdentityInterface $userSession, AlunosTable $alunosTable): Result
    {
        $user_data = $userSession->getOriginalData();

        return $user_data && in_array($user_data['categoria'], ['1', '2'])
            ? new Result(true)
            : new Result(false, 'Erro: alunos declaracao periodo policy not authorized');
    }
}
