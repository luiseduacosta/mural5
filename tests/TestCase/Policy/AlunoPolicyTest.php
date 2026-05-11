<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Aluno;
use App\Model\Entity\User;
use App\Policy\AlunoPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AlunoPolicy Test Case
 */
class AlunoPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\AlunoPolicy
     */
    protected $AlunoPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->AlunoPolicy = new AlunoPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AlunoPolicy);
        parent::tearDown();
    }

    protected function getAdminIdentity(): \Authorization\IdentityInterface
    {
        $user = new User([
            'id' => 1,
            'categoria' => '1',
            'entidade_id' => 1,
        ]);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    protected function getAlunoIdentity(int $id): \Authorization\IdentityInterface
    {
        $user = new User([
            'id' => $id,
            'categoria' => '2',
            'aluno_id' => $id,
            'entidade_id' => $id,
        ]);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->getAdminIdentity();
        $this->assertTrue($this->AlunoPolicy->before($admin, new Aluno(), 'view'));

        $aluno = $this->getAlunoIdentity(2);
        $this->assertNull($this->AlunoPolicy->before($aluno, new Aluno(), 'view'));
    }

    public function testCanView(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new Aluno(['user_id' => 2]);
        $this->assertTrue($this->AlunoPolicy->canView($aluno, $resource)->getStatus());
        $this->assertFalse($this->AlunoPolicy->canView($otherAluno, $resource)->getStatus());
    }

    public function testCanEdit(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new Aluno(['user_id' => 2]);
        $this->assertTrue($this->AlunoPolicy->canEdit($aluno, $resource)->getStatus());
        $this->assertFalse($this->AlunoPolicy->canEdit($otherAluno, $resource)->getStatus());
    }

    public function testCanDelete(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $resource = new Aluno(['user_id' => 2]);
        
        // canDelete always returns false for Aluno policy
        $this->assertFalse($this->AlunoPolicy->canDelete($aluno, $resource)->getStatus());
    }

    public function testCanDeclaracaoperiodo(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new Aluno(['user_id' => 2]);
        $this->assertTrue($this->AlunoPolicy->canDeclaracaoperiodo($aluno, $resource)->getStatus());
        $this->assertFalse($this->AlunoPolicy->canDeclaracaoperiodo($otherAluno, $resource)->getStatus());
    }
}
