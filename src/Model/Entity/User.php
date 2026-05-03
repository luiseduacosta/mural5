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
        'categoria_entidade' => true,
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
     *
     * Dynamically resolves foreign keys by querying related tables
     * when they are null, so policies and controllers can reliably
     * read aluno_id, professor_id, supervisor_id and entidade_id.
     */
    public function getOriginalData(): ArrayAccess|array
    {
        if (empty($this->id) || empty($this->categoria)) {
            return $this;
        }

        if ($this->get('_fk_resolved')) {
            return $this;
        }

        $this->set('_fk_resolved', true);

        $map = [
            '1' => ['table' => 'Administradores', 'fk' => 'entidade_id', 'idField' => null],
            '2' => ['table' => 'Alunos', 'fk' => 'aluno_id', 'idField' => 'registro'],
            '3' => ['table' => 'Professores', 'fk' => 'professor_id', 'idField' => 'siape'],
            '4' => ['table' => 'Supervisores', 'fk' => 'supervisor_id', 'idField' => 'cress'],
        ];

        if (!isset($map[$this->categoria])) {
            return $this;
        }

        $config = $map[$this->categoria];
        $fkField = $config['fk'];

        if (!empty($this->$fkField)) {
            return $this;
        }

        try {
            $table = TableRegistry::getTableLocator()->get($config['table']);
            $record = null;

            $strategies = [
                ["{$config['table']}.user_id" => $this->id],
            ];

            if (!empty($this->email)) {
                $strategies[] = ["{$config['table']}.email" => $this->email];
            }

            if (!empty($this->identificacao) && $config['idField'] !== null) {
                $strategies[] = ["{$config['table']}.{$config['idField']}" => $this->identificacao];
            }

            foreach ($strategies as $conditions) {
                $record = $table->find()
                    ->where($conditions)
                    ->first();
                if ($record) {
                    break;
                }
            }

            if ($record) {
                $this->$fkField = $record->id;

                if (empty($this->entidade_id)) {
                    $this->entidade_id = $record->id;
                }

                if (empty($this->identificacao) && $config['idField'] !== null && isset($record->{$config['idField']})) {
                    $this->identificacao = $record->{$config['idField']};
                }
            }
        } catch (\Throwable) {
            // Silently ignore if table or query fails
        }

        return $this;
    }
}
