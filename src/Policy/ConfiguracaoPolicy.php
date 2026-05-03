<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Configuracao;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

final class ConfiguracaoPolicy implements BeforePolicyInterface
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

            if ($user_data['categoria'] === '1' && !empty($user_data['entidade_id'])) {
                return true;
            }
        }

        return null;
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Configuracao $configuracaoData
     * @return \Authorization\Policy\Result
     */
    public function canView(IdentityInterface $userSession, Configuracao $configuracaoData): Result
    {
        return new Result(true);
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Configuracao $configuracaoData
     * @return \Authorization\Policy\Result
     */
    public function canEdit(IdentityInterface $userSession, Configuracao $configuracaoData): Result
    {
        return new Result(false, 'Erro: configuracao edit policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Configuracao $configuracaoData
     * @return \Authorization\Policy\Result
     */
    public function canDelete(IdentityInterface $userSession, Configuracao $configuracaoData): Result
    {
        return new Result(false, 'Erro: configuracao delete policy not authorized');
    }

    /**
     * @param \Authorization\IdentityInterface $userSession
     * @param \App\Model\Entity\Configuracao $configuracaoData
     * @return \Authorization\Policy\Result
     */
    public function canAdd(IdentityInterface $userSession, Configuracao $configuracaoData): Result
    {
        return new Result(false, 'Erro: configuracao add policy not authorized');
    }
}
