<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Supervisor;
use App\Model\Entity\User;
use App\Policy\SupervisorPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\SupervisorPolicy Test Case
 */
class SupervisorPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\SupervisorPolicy
     */
    protected $SupervisorPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->SupervisorPolicy = new SupervisorPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SupervisorPolicy);
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

    protected function getSupervisorIdentity(int $id): \Authorization\IdentityInterface
    {
        $user = new User([
            'id' => $id,
            'categoria' => '4',
            'supervisor_id' => $id,
            'entidade_id' => $id,
        ]);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->getAdminIdentity();
        $this->assertTrue($this->SupervisorPolicy->before($admin, new Supervisor(), 'view'));

        $supervisor = $this->getSupervisorIdentity(2);
        $this->assertNull($this->SupervisorPolicy->before($supervisor, new Supervisor(), 'view'));
    }

    public function testCanAdd(): void
    {
        $supervisor = $this->getSupervisorIdentity(2);
        $this->assertTrue($this->SupervisorPolicy->canAdd($supervisor, new Supervisor())->getStatus());
        
        $aluno = new User(['id' => 3, 'categoria' => '2']);
        $aluno->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        $alunoIdentity = new \Authorization\Identity($service, $aluno);
        $this->assertFalse($this->SupervisorPolicy->canAdd($alunoIdentity, new Supervisor())->getStatus());
        
        $this->assertFalse($this->SupervisorPolicy->canAdd(null, new Supervisor())->getStatus());
    }

    public function testCanView(): void
    {
        $supervisor = $this->getSupervisorIdentity(2);
        $this->assertTrue($this->SupervisorPolicy->canView($supervisor, new Supervisor())->getStatus());
        $this->assertFalse($this->SupervisorPolicy->canView(null, new Supervisor())->getStatus());
    }

    public function testCanEdit(): void
    {
        $supervisor = $this->getSupervisorIdentity(2);
        $otherSupervisor = $this->getSupervisorIdentity(3);

        $resource = new Supervisor(['user_id' => 2]);
        $this->assertTrue($this->SupervisorPolicy->canEdit($supervisor, $resource)->getStatus());
        $this->assertFalse($this->SupervisorPolicy->canEdit($otherSupervisor, $resource)->getStatus());
    }

    public function testCanDelete(): void
    {
        $supervisor = $this->getSupervisorIdentity(2);
        $resource = new Supervisor(['user_id' => 2]);
        
        $this->assertFalse($this->SupervisorPolicy->canDelete($supervisor, $resource)->getStatus());
    }
}
