<?php
<<<<<<< HEAD

=======
>>>>>>> main
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Inscricao;
use Authorization\IdentityInterface;
<<<<<<< HEAD

/**
 * Inscricao policy
 */
class InscricaoPolicy
{
    /**
     * Check if $user can add Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canAdd(?IdentityInterface $user, Inscricao $inscricao)
    {
        return isset($user->categoria) && ($user->categoria == 1 || $user->categoria == 2);
    }

    /**
     * Check if $user can edit Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canEdit(?IdentityInterface $user, Inscricao $inscricao)
    {
        return isset($user->categoria) && $user->categoria == 1;
    }

    /**
     * Check if $user can delete Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canDelete(?IdentityInterface $user, Inscricao $inscricao)
    {
        if (isset($user->categoria) && $user->categoria == 1) {
            return true;
        } elseif (isset($user->categoria) && $user->categoria == 2) {
            return $inscricao->aluno_id == $user->aluno_id;
        }
        return false;
    }

    /**
     * Check if $user can view Inscricao
     *
     * @param \Authorization\IdentityInterface|null $user The user.
     * @param \App\Model\Entity\Inscricao $inscricao
     * @return bool
     */
    public function canView(?IdentityInterface $user, Inscricao $inscricao)
    {
        return isset($user->categoria) && ($user->categoria == 1 || $user->categoria == 2);
=======
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class InscricaoPolicy implements BeforePolicyInterface
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
                $user_data
                && (
                    ($user_data['categoria'] === '1' && !empty($user_data['entidade_id']))
                    || $user_data['professor_id']
                )
            ) {
                return true;
            }
        }

        return null;
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Inscricao $inscricaoData
     * @return \Authorization\Policy\Result
     */
    public function canView(IdentityInterface $userSession, Inscricao $inscricaoData): Result
    {
        return $this->sameUser($userSession, $inscricaoData)
            ? new Result(true)
            : new Result(false, 'Erro: inscricoes view policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Inscricao $inscricaoData
     * @return \Authorization\Policy\Result
     */
    public function canEdit(IdentityInterface $userSession, Inscricao $inscricaoData): Result
    {
        return $this->sameUser($userSession, $inscricaoData)
            ? new Result(true)
            : new Result(false, 'Erro: inscricoes edit policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Inscricao $inscricaoData
     * @return \Authorization\Policy\Result
     */
    public function canDelete(IdentityInterface $userSession, Inscricao $inscricaoData): Result
    {
        return new Result(false, 'Erro: inscricoes delete policy not allowed');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Inscricao $inscricaoData
     * @return bool
     */
    protected function sameUser(IdentityInterface $userSession, Inscricao $inscricaoData): bool
    {
        return $userSession->id === $inscricaoData->aluno->user_id;
>>>>>>> main
    }
}
