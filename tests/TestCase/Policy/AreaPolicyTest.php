<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Area;
use App\Model\Entity\User;
use App\Policy\AreaPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AreaPolicy Test Case
 */
class AreaPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\AreaPolicy
     */
    protected $AreaPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->AreaPolicy = new AreaPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->AreaPolicy);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->AreaPolicy->before($admin, new Area(), 'view'));
        $this->assertNull($this->AreaPolicy->before($aluno, new Area(), 'view'));
    }

    public function testCanView(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->AreaPolicy->canView($user, new Area())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->AreaPolicy->canEdit($user, new Area())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $user = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->AreaPolicy->canDelete($user, new Area())->getStatus());
    }
}
