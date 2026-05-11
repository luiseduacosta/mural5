<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\User;
use Cake\TestSuite\TestCase;

class UserTest extends TestCase
{
    protected array $fixtures = ['app.Users'];

    public function testIsAdmin(): void
    {
        $user = new User(['categoria' => '1']);
        $this->assertTrue($user->isAdmin());

        $user->categoria = '2';
        $this->assertFalse($user->isAdmin());

        $user->categoria = '3';
        $this->assertFalse($user->isAdmin());

        $user->categoria = '4';
        $this->assertFalse($user->isAdmin());
    }

    public function testIsAluno(): void
    {
        $user = new User(['categoria' => '2']);
        $this->assertTrue($user->isAluno());

        $user->categoria = '1';
        $this->assertFalse($user->isAluno());

        $user->categoria = '3';
        $this->assertFalse($user->isAluno());

        $user->categoria = '4';
        $this->assertFalse($user->isAluno());
    }

    public function testIsProfessor(): void
    {
        $user = new User(['categoria' => '3']);
        $this->assertTrue($user->isProfessor());

        $user->categoria = '1';
        $this->assertFalse($user->isProfessor());

        $user->categoria = '2';
        $this->assertFalse($user->isProfessor());

        $user->categoria = '4';
        $this->assertFalse($user->isProfessor());
    }

    public function testIsSupervisor(): void
    {
        $user = new User(['categoria' => '4']);
        $this->assertTrue($user->isSupervisor());

        $user->categoria = '1';
        $this->assertFalse($user->isSupervisor());

        $user->categoria = '2';
        $this->assertFalse($user->isSupervisor());

        $user->categoria = '3';
        $this->assertFalse($user->isSupervisor());
    }

    public function testRoleForCategoria(): void
    {
        $user = new User(['categoria' => '1']);
        $this->assertSame('admin', $user->roleForCategoria());

        $user->categoria = '2';
        $this->assertSame('aluno', $user->roleForCategoria());

        $user->categoria = '3';
        $this->assertSame('professor', $user->roleForCategoria());

        $user->categoria = '4';
        $this->assertSame('supervisor', $user->roleForCategoria());

        $user->categoria = '999';
        $this->assertNull($user->roleForCategoria());
    }

    public function testSetPassword(): void
    {
        $user = new User(['password' => 'plaintextpassword']);
        
        $this->assertNotSame('plaintextpassword', $user->password);
        $this->assertIsString($user->password);
        $this->assertGreaterThan(8, strlen($user->password));
        
        $hasher = new \Authentication\PasswordHasher\DefaultPasswordHasher();
        $this->assertTrue($hasher->check('plaintextpassword', $user->password));
    }

    public function testGetOriginalDataWithoutIdOrCategoria(): void
    {
        $user = new User();
        $result = $user->getOriginalData();
        $this->assertInstanceOf(User::class, $result);
        $this->assertFalse($result->has('_fk_resolved'));
    }

    public function testGetOriginalDataWithFkResolved(): void
    {
        $user = new User(['id' => 1, 'categoria' => '1', '_fk_resolved' => true]);
        $result = $user->getOriginalData();
        $this->assertInstanceOf(User::class, $result);
        $this->assertTrue($result->get('_fk_resolved'));
    }

    public function testGetOriginalDataWithExistingFk(): void
    {
        $user = new User(['id' => 1, 'categoria' => '2', 'aluno_id' => 5]);
        $result = $user->getOriginalData();
        $this->assertInstanceOf(User::class, $result);
        $this->assertSame(5, $result->aluno_id);
    }
}
