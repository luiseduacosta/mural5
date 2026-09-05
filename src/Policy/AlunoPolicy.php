<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Aluno;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class AlunoPolicy implements BeforePolicyInterface
{
    /**
     * @param IdentityInterface|null $identity
     * @param mixed $resource
     * @param string $action
     * @return ResultInterface|bool|null
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
     * @param IdentityInterface $userSession
     * @param Aluno $alunoData
     * @return Result
     */
    public function canView(IdentityInterface $userSession, Aluno $alunoData): Result
    {
        return $this->sameUser($userSession, $alunoData)
            ? new Result(true)
            : new Result(false, 'Erro: aluno view policy not authorized');
    }

    /**
     * @param IdentityInterface $userSession
     * @param Aluno $alunoData
     * @return Result
     */
    public function canEdit(IdentityInterface $userSession, Aluno $alunoData): Result
    {
        return $this->sameUser($userSession, $alunoData)
            ? new Result(true)
            : new Result(false, 'Erro: aluno edit policy not authorized');
    }

    /**
     * @param IdentityInterface $userSession
     * @param Aluno $alunoData
     * @return Result
     */
    public function canDelete(IdentityInterface $userSession, Aluno $alunoData): Result
    {
        return new Result(false, 'Erro: aluno delete policy not allowed');
    }

    /**
     * @param IdentityInterface $userSession
     * @param Aluno $alunoData
     * @return Result
     */
    public function canDeclaracaoperiodo(IdentityInterface $userSession, Aluno $alunoData): Result
    {
        return $this->sameUser($userSession, $alunoData)
            ? new Result(true)
            : new Result(false, 'Erro: aluno declaracao periodo policy not authorized');
    }

    /**
     * @param IdentityInterface $userSession
     * @param Aluno $alunoData
     * @return Result
     */
    public function canDeclaracaoperiodopdf(IdentityInterface $userSession, Aluno $alunoData): Result
    {
        return $this->sameUser($userSession, $alunoData)
            ? new Result(true)
            : new Result(false, 'Erro: aluno declaracao periodo policy not authorized');
    }

    /**
     * @param IdentityInterface $userSession
     * @param Aluno $alunoData
     * @return bool
     */
    protected function sameUser(IdentityInterface $userSession, Aluno $alunoData): bool
    {
        $user_data = $userSession->getOriginalData();
        if (!($user_data instanceof \ArrayAccess || is_array($user_data))) {
            return false;
        }

        // Aluno user: must be the same aluno record (resolved via aluno_id FK from User entity)
        $alunoId = $user_data['aluno_id'] ?? null;
        if (!empty($alunoId)) {
            return (int)$alunoId === (int)$alunoData->id;
        }

        // Professor or Supervisor user: allow access to any aluno record (typical oversight role)
        if (!empty($user_data['professor_id']) || !empty($user_data['supervisor_id'])) {
            return true;
        }

        // Final fallback: legacy user_id match (kept for data consistency in edge cases)
        if (!empty($user_data['id']) && $alunoData->has('user_id') && $alunoData->user_id !== null) {
            return (int)$user_data['id'] === (int)$alunoData->user_id;
        }

        return false;
    }
}
