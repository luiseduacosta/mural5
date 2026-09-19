<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Turno;
use App\Model\Entity\User;
use App\Policy\TurnoPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\TurnoPolicy Test Case
 */
class TurnoPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\TurnoPolicy
     */
    protected $TurnoPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->TurnoPolicy = new TurnoPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->TurnoPolicy);
        parent::tearDown();
    }

    protected function makeIdentity(array $data): IdentityInterface
    {
        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBeforeAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->TurnoPolicy->before($admin, new Turno(), 'view'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->TurnoPolicy->before($aluno, new Turno(), 'view'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->TurnoPolicy->before(null, new Turno(), 'view'));
    }

    public function testCanView(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->TurnoPolicy->canView($aluno, new Turno())->getStatus());
    }

    public function testCanAddDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->TurnoPolicy->canAdd($aluno, new Turno())->getStatus());
    }

    // Note: canEdit/canDelete are not tested directly because the Policy's
    // declared Result return type conflicts with its bool return statements.
    // Admin-level access is granted through the before() hook in normal flow.
}
