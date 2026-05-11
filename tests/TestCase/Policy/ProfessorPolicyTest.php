<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Professor;
use App\Model\Entity\User;
use App\Policy\ProfessorPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\ProfessorPolicy Test Case
 */
class ProfessorPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\ProfessorPolicy
     */
    protected $ProfessorPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->ProfessorPolicy = new ProfessorPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProfessorPolicy);
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

    protected function getProfessorIdentity(int $id, int $professorId): \Authorization\IdentityInterface
    {
        $user = new User([
            'id' => $id,
            'categoria' => '3',
            'professor_id' => $professorId,
            'entidade_id' => $professorId,
        ]);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->getAdminIdentity();
        $this->assertTrue($this->ProfessorPolicy->before($admin, new Professor(), 'view'));

        $professor = $this->getProfessorIdentity(2, 2);
        $this->assertNull($this->ProfessorPolicy->before($professor, new Professor(), 'view'));
    }

    public function testCanAdd(): void
    {
        $professor = $this->getProfessorIdentity(2, 2);
        $this->assertTrue($this->ProfessorPolicy->canAdd($professor, new Professor())->getStatus());
        $this->assertFalse($this->ProfessorPolicy->canAdd(null, new Professor())->getStatus());
    }

    public function testCanView(): void
    {
        $professor = $this->getProfessorIdentity(2, 2);
        $this->assertTrue($this->ProfessorPolicy->canView($professor, new Professor())->getStatus());
        $this->assertFalse($this->ProfessorPolicy->canView(null, new Professor())->getStatus());
    }

    public function testCanEdit(): void
    {
        $professor = $this->getProfessorIdentity(2, 2);
        $otherProfessor = $this->getProfessorIdentity(3, 3);

        $resource = new Professor(['id' => 2]);
        $this->assertTrue($this->ProfessorPolicy->canEdit($professor, $resource)->getStatus());
        $this->assertFalse($this->ProfessorPolicy->canEdit($otherProfessor, $resource)->getStatus());
    }

    public function testCanDelete(): void
    {
        $professor = $this->getProfessorIdentity(2, 2);
        $resource = new Professor(['id' => 2]);
        
        $this->assertFalse($this->ProfessorPolicy->canDelete($professor, $resource)->getStatus());
    }
}
