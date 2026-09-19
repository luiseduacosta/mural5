<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\InscricoesTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\InscricoesTablePolicy Test Case
 */
class InscricoesTablePolicyTest extends TestCase
{
    protected $InscricoesTablePolicy;
    protected $Inscricoes;

    protected array $fixtures = [
        'app.Users',
        'app.Inscricoes',
        'app.Alunos',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->InscricoesTablePolicy = new InscricoesTablePolicy();
        $this->Inscricoes = TableRegistry::getTableLocator()->get('Inscricoes');
    }

    protected function tearDown(): void
    {
        unset($this->InscricoesTablePolicy, $this->Inscricoes);
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
        $this->assertTrue($this->InscricoesTablePolicy->before($admin, $this->Inscricoes, 'index'));
    }

    public function testBeforeAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 10]);
        $this->assertTrue($this->InscricoesTablePolicy->before($aluno, $this->Inscricoes, 'index'));
    }

    public function testBeforeProfessorDenied(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3', 'aluno_id' => null]);
        $this->assertNull($this->InscricoesTablePolicy->before($professor, $this->Inscricoes, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->InscricoesTablePolicy->before(null, $this->Inscricoes, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->InscricoesTablePolicy->canIndex($aluno, $this->Inscricoes)->getStatus());
    }

    public function testScopeIndexAdminNoFilter(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $query = $this->Inscricoes->find();
        $scoped = $this->InscricoesTablePolicy->scopeIndex($admin, clone $query);
        $this->assertEmpty($scoped->clause('where'));
    }

    public function testScopeIndexAlunoFiltersByAlunoId(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 10]);
        $query = $this->Inscricoes->find();
        $scoped = $this->InscricoesTablePolicy->scopeIndex($aluno, clone $query);
        $this->assertNotEmpty($scoped->clause('where'));
    }

    public function testScopeIndexNoAlunoReturnsEmpty(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3', 'aluno_id' => null]);
        $query = $this->Inscricoes->find();
        $scoped = $this->InscricoesTablePolicy->scopeIndex($professor, clone $query);
        $this->assertNotEmpty($scoped->clause('where'));
    }

    public function testCanAddAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->InscricoesTablePolicy->canAdd($admin, $this->Inscricoes)->getStatus());
    }

    public function testCanAddAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'aluno_id' => 10]);
        $this->assertTrue($this->InscricoesTablePolicy->canAdd($aluno, $this->Inscricoes)->getStatus());
    }

    public function testCanAddProfessorDenied(): void
    {
        $professor = $this->makeIdentity(['id' => 3, 'categoria' => '3', 'aluno_id' => null]);
        $this->assertFalse($this->InscricoesTablePolicy->canAdd($professor, $this->Inscricoes)->getStatus());
    }

    public function testCanBuscaDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->InscricoesTablePolicy->canBusca($aluno, $this->Inscricoes)->getStatus());
    }
}
