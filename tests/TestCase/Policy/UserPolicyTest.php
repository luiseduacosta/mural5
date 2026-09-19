<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\UserPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\UserPolicy Test Case
 */
class UserPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\UserPolicy
     */
    protected $UserPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->UserPolicy = new UserPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserPolicy);
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
        $this->assertTrue($this->UserPolicy->before($admin, new User(), 'view'));

        $aluno = $this->getAlunoIdentity(2);
        $this->assertNull($this->UserPolicy->before($aluno, new User(), 'view'));
    }

    public function testCanView(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new User(['id' => 2]);
        $this->assertTrue($this->UserPolicy->canView($aluno, $resource)->getStatus());

        $this->assertFalse($this->UserPolicy->canView($otherAluno, $resource)->getStatus());
    }

    public function testCanEdit(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new User(['id' => 2]);
        $this->assertTrue($this->UserPolicy->canEdit($aluno, $resource)->getStatus());

        $this->assertFalse($this->UserPolicy->canEdit($otherAluno, $resource)->getStatus());
    }

    public function testCanEditpassword(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new User(['id' => 2]);
        $this->assertTrue($this->UserPolicy->canEditpassword($aluno, $resource)->getStatus());

        $this->assertFalse($this->UserPolicy->canEditpassword($otherAluno, $resource)->getStatus());
    }

    public function testCanDelete(): void
    {
        $aluno = $this->getAlunoIdentity(2);
        $otherAluno = $this->getAlunoIdentity(3);

        $resource = new User(['id' => 2]);
        $this->assertTrue($this->UserPolicy->canDelete($aluno, $resource)->getStatus());

        $this->assertFalse($this->UserPolicy->canDelete($otherAluno, $resource)->getStatus());
    }
}
