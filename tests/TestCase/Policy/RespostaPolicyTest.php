<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Resposta;
use App\Model\Entity\User;
use App\Policy\RespostaPolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\RespostaPolicy Test Case
 */
class RespostaPolicyTest extends TestCase
{
    /**
     * @var \App\Policy\RespostaPolicy
     */
    protected $RespostaPolicy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->RespostaPolicy = new RespostaPolicy();
    }

    protected function tearDown(): void
    {
        unset($this->RespostaPolicy);
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
        $this->assertTrue($this->RespostaPolicy->before($admin, new Resposta(), 'view'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->RespostaPolicy->before($aluno, new Resposta(), 'view'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->RespostaPolicy->before(null, new Resposta(), 'view'));
    }

    public function testCanAddAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->RespostaPolicy->canAdd($aluno, new Resposta())->getStatus());
    }

    public function testCanAddProfessorDenied(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3']);
        $this->assertFalse($this->RespostaPolicy->canAdd($professor, new Resposta())->getStatus());
    }

    public function testCanAddSupervisorDenied(): void
    {
        $supervisor = $this->makeIdentity(['id' => 4, 'categoria' => '4']);
        $this->assertFalse($this->RespostaPolicy->canAdd($supervisor, new Resposta())->getStatus());
    }

    public function testCanEditAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->RespostaPolicy->canEdit($aluno, new Resposta())->getStatus());
    }

    public function testCanEditProfessorDenied(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3']);
        $this->assertFalse($this->RespostaPolicy->canEdit($professor, new Resposta())->getStatus());
    }

    public function testCanDeleteAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->RespostaPolicy->canDelete($aluno, new Resposta())->getStatus());
    }

    public function testCanDeleteProfessorDenied(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3']);
        $this->assertFalse($this->RespostaPolicy->canDelete($professor, new Resposta())->getStatus());
    }

    public function testCanView(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->RespostaPolicy->canView($aluno, new Resposta())->getStatus());
    }
}
