<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\RespostasTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\RespostasTablePolicy Test Case
 */
class RespostasTablePolicyTest extends TestCase
{
    protected $RespostasTablePolicy;
    protected $Respostas;

    protected array $fixtures = [
        'app.Users',
        'app.Respostas',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->RespostasTablePolicy = new RespostasTablePolicy();
        $this->Respostas = TableRegistry::getTableLocator()->get('Respostas');
    }

    protected function tearDown(): void
    {
        unset($this->RespostasTablePolicy, $this->Respostas);
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
        $this->assertTrue($this->RespostasTablePolicy->before($admin, $this->Respostas, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->RespostasTablePolicy->before($aluno, $this->Respostas, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->RespostasTablePolicy->before(null, $this->Respostas, 'index'));
    }

    public function testCanIndexAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->RespostasTablePolicy->canIndex($admin, $this->Respostas)->getStatus());
    }

    public function testCanIndexAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->RespostasTablePolicy->canIndex($aluno, $this->Respostas)->getStatus());
    }

    public function testCanIndexProfessorDenied(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3']);
        $this->assertFalse($this->RespostasTablePolicy->canIndex($professor, $this->Respostas)->getStatus());
    }

    public function testCanIndexUnauthenticatedDenied(): void
    {
        $this->assertFalse($this->RespostasTablePolicy->canIndex(null, $this->Respostas)->getStatus());
    }
}
