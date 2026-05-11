<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Model\Entity\Visita;
use App\Policy\VisitaPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\VisitaPolicy Test Case
 */
class VisitaPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\VisitaPolicy
     */
    protected $VisitaPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->VisitaPolicy = new VisitaPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->VisitaPolicy);
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
        $this->assertTrue($this->VisitaPolicy->before($admin, new Visita(), 'view'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->VisitaPolicy->before($aluno, new Visita(), 'view'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->VisitaPolicy->before(null, new Visita(), 'view'));
    }

    public function testCanView(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->VisitaPolicy->canView($aluno, new Visita())->getStatus());
    }

    public function testCanEditAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->VisitaPolicy->canEdit($admin, new Visita())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->VisitaPolicy->canEdit($aluno, new Visita())->getStatus());
    }

    public function testCanDeleteAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->VisitaPolicy->canDelete($admin, new Visita())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->VisitaPolicy->canDelete($aluno, new Visita())->getStatus());
    }
}
