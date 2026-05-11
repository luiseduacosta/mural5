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
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return \Authorization\Policy\Result
     */
    public function canAdd(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        // Add ownership check if needed
        return new Result(true);
    }


    /**
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return \Authorization\Policy\Result
     */
    public function canView(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        return $this->sameUser($user, $folhadeatividade)
            ? new Result(true)
            : new Result(false, 'Erro: folhadeatividade view policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return \Authorization\Policy\Result
     */
    public function canEdit(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        return $this->sameUser($user, $folhadeatividade)
            ? new Result(true)
            : new Result(false, 'Erro: folhadeatividade edit policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $user
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return \Authorization\Policy\Result
     */
    public function canDelete(IdentityInterface $user, Folhadeatividade $folhadeatividade): Result
    {
        return $this->sameUser($user, $folhadeatividade)
            ? new Result(true)
            : new Result(false, 'Erro: folhadeatividade delete policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Folhadeatividade $folhadeatividade
     * @return bool
     */
    protected function sameUser(IdentityInterface $userSession, Folhadeatividade $folhadeatividade): bool
    {
        $user_data = $userSession->getOriginalData();
        if (!is_array($user_data) || empty($user_data['aluno_id'])) {
            return false;
        }

        $estagiario = $folhadeatividade->get('estagiario');
        if (!$estagiario instanceof \Cake\Datasource\EntityInterface) {
            return false;
        }

        return (int)$user_data['aluno_id'] === (int)$estagiario->get('aluno_id');
    }
}
