<?php
declare(strict_types=1);

namespace App\Model\Entity;

use ArrayAccess;
use Authentication\IdentityInterface as AuthenticationIdentity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

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
    /**
     * Mapping of categoria values to role values.
     */
    public const CATEGORIA_ROLE_MAP = [
        '1' => 'admin',
        '2' => 'aluno',
        '3' => 'professor',
        '4' => 'supervisor',
    ];

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

    // Automatically hash passwords when they are changed.
    protected array $_hidden = ['password'];

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

    public function isAdmin(): bool
    {
        return $this->categoria === '1';
    }

    public function isAluno(): bool
    {
        return $this->categoria === '2';
    }

    public function isProfessor(): bool
    {
        return $this->categoria === '3';
    }

    public function isSupervisor(): bool
    {
        return $this->categoria === '4';
    }

    /**
     * Returns the role value for the current categoria.
     *
     * @return string|null
     */
    public function roleForCategoria(): ?string
    {
        return self::CATEGORIA_ROLE_MAP[$this->categoria] ?? null;
    }

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
        return $this;
    }
}
