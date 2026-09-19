<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Turma;
use App\Model\Entity\User;
use App\Policy\TurmaPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\TurmaPolicy Test Case
 */
class TurmaPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\TurmaPolicy
     */
    protected $TurmaPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->TurmaPolicy = new TurmaPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->TurmaPolicy);
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
        $this->assertTrue($this->TurmaPolicy->before($admin, new Turma(), 'view'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->TurmaPolicy->before($aluno, new Turma(), 'view'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->TurmaPolicy->before(null, new Turma(), 'view'));
    }

    public function testCanView(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->TurmaPolicy->canView($aluno, new Turma())->getStatus());
    }

    public function testCanAddDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->TurmaPolicy->canAdd($aluno, new Turma())->getStatus());
    }

    public function testCanEditDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->TurmaPolicy->canEdit($aluno, new Turma())->getStatus());
    }

    public function testCanDeleteDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->TurmaPolicy->canDelete($aluno, new Turma())->getStatus());
    }
}
