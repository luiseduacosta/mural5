<?php
declare(strict_types=1);

namespace App\Model\Entity;

use ArrayAccess;
use Authentication\IdentityInterface as AuthenticationIdentity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * User Entity
 *
 * @property int $id
 * @property string $nome
 * @property string|null $email
 * @property string|null $password
 * @property string $categoria
 * @property string $role
 * @property int|null $identificacao
 * @property int|null $entidade_id
 * @property int|null $aluno_id
 * @property int|null $supervisor_id
 * @property int|null $professor_id
 * @property int|null $administrador_id
 * @property int $ativo
 * @property \Cake\I18n\FrozenTime $criado_em
 * @property \Cake\I18n\FrozenTime $atualizado_em
 *
 * @property \App\Model\Entity\Categoria $categoria
 * @property \App\Model\Entity\Aluno $aluno
 * @property \App\Model\Entity\Supervisor $supervisor
 * @property \App\Model\Entity\Professor $professor
 * @property \App\Model\Entity\Administrador $administrador
 */
class User extends Entity implements AuthenticationIdentity
{
    protected array $_accessible = [
        'nome' => true,
        'email' => true,
        'password' => true,
        'categoria' => true,
        'role' => true,
        'identificacao' => true,
        'entidade_id' => true,
        'aluno_id' => true,
        'supervisor_id' => true,
        'professor_id' => true,
        'ativo' => true,
        'criado_em' => true,
        'atualizado_em' => true,
        'categoria_obj' => true,
        'aluno' => true,
        'supervisor' => true,
        'professor' => true,
        'administrador' => true,
    ];

    protected array $_hidden = ['password'];

    public function isAdmin(): bool
    {
        return $this->categoria === '1';
    }

    public function isProfessor(): bool
    {
        return $this->categoria === '3';
    }

    public function isSupervisor(): bool
    {
        return $this->categoria === '4';
    }

    public function isAluno(): bool
    {
        return $this->categoria === '2';
    }

    // Automatically hash passwords when they are changed.

    /**
     * Set password hook - automatically hashes the password.
     *
     * @param string $password The plain text password.
     * @return string The hashed password.
     */
    protected function _setPassword(string $password): string
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }

    /**
     * Flag to prevent multiple database queries when fetching original data.
     */
    protected bool $_originalDataLoaded = false;

    /**
     * Authentication\IdentityInterface method
     */
    public function getIdentifier(): array|string|int|null
    {
        return $this->id;
    }

    /**
     * Authentication\IdentityInterface method
     */
    public function getOriginalData(): ArrayAccess|array
    {
        if ($this->_originalDataLoaded) {
            return $this;
        }

        $this->_originalDataLoaded = true;

        $categoria = $this->categoria ?? '0';

        if (!isset($this->aluno_id)) {
            $this->aluno_id = null;
        }
        if (!isset($this->professor_id)) {
            $this->professor_id = null;
        }
        if (!isset($this->supervisor_id)) {
            $this->supervisor_id = null;
        }
        if (!isset($this->administrador_id)) {
            $this->administrador_id = null;
        }

        if ($categoria === '2' && empty($this->aluno_id)) {
            $alunos = TableRegistry::getTableLocator()->get('Alunos');
            $aluno = $alunos->find()
                ->where(['Alunos.user_id' => $this->id])
                ->first();

            if (empty($aluno) && !empty($this->email)) {
                $aluno = $alunos->find()
                    ->where(['Alunos.email' => $this->email])
                    ->first();
            }

            if (!empty($aluno)) {
                $this->aluno_id = $aluno->id;
            }
        }

        if ($categoria === '3' && empty($this->professor_id)) {
            $professores = TableRegistry::getTableLocator()->get('Professores');
            $professor = $professores->find()
                ->where(['Professores.user_id' => $this->id])
                ->first();

            if (empty($professor) && !empty($this->email)) {
                $professor = $professores->find()
                    ->where(['Professores.email' => $this->email])
                    ->first();
            }

            if (!empty($professor)) {
                $this->professor_id = $professor->id;
            }
        }

        if ($categoria === '4' && empty($this->supervisor_id)) {
            $supervisores = TableRegistry::getTableLocator()->get('Supervisores');
            $supervisor = $supervisores->find()
                ->where(['Supervisores.user_id' => $this->id])
                ->first();

            if (empty($supervisor) && !empty($this->email)) {
                $supervisor = $supervisores->find()
                    ->where(['Supervisores.email' => $this->email])
                    ->first();
            }

            if (!empty($supervisor)) {
                $this->supervisor_id = $supervisor->id;
            }
        }

        if (empty($this->administrador_id)) {
            $administradores = TableRegistry::getTableLocator()->get('Administradores');
            $administrador = $administradores->find()
                ->where(['Administradores.user_id' => $this->id])
                ->first();

            if (!empty($administrador)) {
                $this->administrador_id = $administrador->id;
            }
        }

        if ($categoria === '1' && empty($this->administrador_id)) {
            $this->administrador_id = 1;
        }

        return $this;
    }
}
