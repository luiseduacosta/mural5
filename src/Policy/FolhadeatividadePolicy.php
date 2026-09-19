<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Folhadeatividade;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class FolhadeatividadePolicy implements BeforePolicyInterface
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
     * @param IdentityInterface $user
     * @param Folhadeatividade $folhadeatividade
     * @return Result
     */
    public function canAdd(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        // Add ownership check if needed
        return new Result(true);
    }


    /**
     * @param IdentityInterface $user
     * @param Folhadeatividade $folhadeatividade
     * @return Result
     */
    public function canView(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        return $this->sameUser($user, $folhadeatividade)
            ? new Result(true)
            : new Result(false, 'Erro: folhadeatividade view policy not authorized');
    }

    /**
     * @param IdentityInterface $user
     * @param Folhadeatividade $folhadeatividade
     * @return Result
     */
    public function canEdit(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        return $this->sameUser($user, $folhadeatividade)
            ? new Result(true)
            : new Result(false, 'Erro: folhadeatividade edit policy not authorized');
    }

    /**
     * @param IdentityInterface $user
     * @param Folhadeatividade $folhadeatividade
     * @return Result
     */
    public function canDelete(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        return $this->sameUser($user, $folhadeatividade)
            ? new Result(true)
            : new Result(false, 'Erro: folhadeatividade delete policy not authorized');
    }

    /**
     * @param IdentityInterface $userSession
     * @param Folhadeatividade $folhadeatividade
     * @return bool
     */
    protected function sameUser(IdentityInterface $userSession, Folhadeatividade $folhadeatividade): bool
    {
        $user_data = $userSession->getOriginalData();
        if (!($user_data instanceof \ArrayAccess || is_array($user_data)) || empty($user_data['aluno_id'])) {
            return false;
        }

        $estagiario = $folhadeatividade->get('estagiario');
        if (!$estagiario instanceof \Cake\Datasource\EntityInterface) {
            return false;
        }

        if ($estagiario->get('aluno_id') !== null) {
            return (int) $user_data['aluno_id'] === (int) $estagiario->get('aluno_id');
        }

        if (isset($estagiario->aluno->user_id)) {
            return (int) $user_data['id'] === (int) $estagiario->aluno->user_id;
        }

        return false;
    }
}
