<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Administrador;
use App\Model\Entity\User;
use App\Policy\AdministradorPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AdministradorPolicy Test Case
 */
class AdministradorPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\AdministradorPolicy
     */
    protected $AdministradorPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->AdministradorPolicy = new AdministradorPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->AdministradorPolicy);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBeforeAdminReturnsTrue(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->AdministradorPolicy->before($admin, new Administrador(), 'view'));
    }

    public function testBeforeAdminOnAddReturnsNull(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertNull($this->AdministradorPolicy->before($admin, new Administrador(), 'add'));
    }

    public function testBeforeNonAdminReturnsNull(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 2]);
        $this->assertNull($this->AdministradorPolicy->before($aluno, new Administrador(), 'view'));
    }

    public function testCanAddAdminSelfUser(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $resource = new Administrador(['user_id' => 1]);
        $this->assertTrue($this->AdministradorPolicy->canAdd($admin, $resource)->getStatus());
    }

    public function testCanAddNonAdminDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $resource = new Administrador(['user_id' => 2]);
        $this->assertFalse($this->AdministradorPolicy->canAdd($aluno, $resource)->getStatus());
    }

    public function testCanViewAlwaysDenied(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertFalse($this->AdministradorPolicy->canView($admin, new Administrador())->getStatus());
    }

    public function testCanEditAlwaysDenied(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertFalse($this->AdministradorPolicy->canEdit($admin, new Administrador())->getStatus());
    }

    public function testCanDeleteAlwaysDenied(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertFalse($this->AdministradorPolicy->canDelete($admin, new Administrador())->getStatus());
    }
}
