<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\AlunosTablePolicy;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AlunosTablePolicy Test Case
 */
class AlunosTablePolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\AlunosTablePolicy
     */
    protected $AlunosTablePolicy;

    /**
     * @var \App\Model\Table\AlunosTable
     */
    protected $Alunos;

    protected array $fixtures = [
        'app.Users',
        'app.Alunos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->AlunosTablePolicy = new AlunosTablePolicy();
        $this->Alunos = TableRegistry::getTableLocator()->get('Alunos');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AlunosTablePolicy);
        unset($this->Alunos);
        parent::tearDown();
    }

    protected function getIdentity(string $categoria, int $id): \Authorization\IdentityInterface
    {
        $data = [
            'id' => $id,
            'categoria' => $categoria,
            'entidade_id' => $id,
        ];
        
        if ($categoria === '2') {
            $data['aluno_id'] = $id;
        } elseif ($categoria === '3') {
            $data['professor_id'] = $id;
        } elseif ($categoria === '4') {
            $data['supervisor_id'] = $id;
        }

        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->getIdentity('1', 1);
        $aluno = $this->getIdentity('2', 2);

        $this->assertTrue($this->AlunosTablePolicy->before($admin, $this->Alunos, 'index'));
        $this->assertNull($this->AlunosTablePolicy->before($aluno, $this->Alunos, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $professor = $this->getIdentity('3', 3);
        
        $this->assertTrue($this->AlunosTablePolicy->canIndex($aluno, $this->Alunos)->getStatus());
        $this->assertTrue($this->AlunosTablePolicy->canIndex($professor, $this->Alunos)->getStatus());
    }

    public function testScopeIndex(): void
    {
        $admin = $this->getIdentity('1', 1);
        $aluno = $this->getIdentity('2', 2);

        $query = $this->Alunos->find();
        $adminQuery = $this->AlunosTablePolicy->scopeIndex($admin, clone $query);
        
        // Admin query should not have user_id condition added
        $this->assertEmpty($adminQuery->clause('where'));

        $alunoQuery = $this->AlunosTablePolicy->scopeIndex($aluno, clone $query);
        // Aluno query should have where condition
        $this->assertNotEmpty($alunoQuery->clause('where'));
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $professor = $this->getIdentity('3', 3);
        
        $this->assertTrue($this->AlunosTablePolicy->canAdd($aluno, $this->Alunos)->getStatus());
        $this->assertFalse($this->AlunosTablePolicy->canAdd($professor, $this->Alunos)->getStatus());
    }

    public function testCanBusca(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->AlunosTablePolicy->canBusca($aluno, $this->Alunos)->getStatus());
    }

    public function testCanPlanilhacress(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertFalse($this->AlunosTablePolicy->canPlanilhacress($aluno, clone $this->Alunos)->getStatus());
    }

    public function testCanDeclaracaoperiodo(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $professor = $this->getIdentity('3', 3);
        
        $this->assertTrue($this->AlunosTablePolicy->canDeclaracaoperiodo($aluno, $this->Alunos)->getStatus());
        $this->assertFalse($this->AlunosTablePolicy->canDeclaracaoperiodo($professor, $this->Alunos)->getStatus());
    }
}
