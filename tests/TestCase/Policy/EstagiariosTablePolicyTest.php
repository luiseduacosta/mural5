<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\EstagiariosTablePolicy;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\EstagiariosTablePolicy Test Case
 */
class EstagiariosTablePolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\EstagiariosTablePolicy
     */
    protected $EstagiariosTablePolicy;

    /**
     * @var \Cake\ORM\Table
     */
    protected $Estagiarios;

    protected array $fixtures = [
        'app.Users',
        'app.Estagiarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->EstagiariosTablePolicy = new EstagiariosTablePolicy();
        $this->Estagiarios = TableRegistry::getTableLocator()->get('Estagiarios');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EstagiariosTablePolicy);
        unset($this->Estagiarios);
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

        $this->assertTrue($this->EstagiariosTablePolicy->before($admin, $this->Estagiarios, 'index'));
        $this->assertNull($this->EstagiariosTablePolicy->before($aluno, $this->Estagiarios, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        
        $this->assertTrue($this->EstagiariosTablePolicy->canIndex($aluno, $this->Estagiarios)->getStatus());
    }

    public function testScopeIndex(): void
    {
        $admin = $this->getIdentity('1', 1);
        $aluno = $this->getIdentity('2', 2);
        $professor = $this->getIdentity('3', 3);
        $supervisor = $this->getIdentity('4', 4);
        $unknown = $this->getIdentity('99', 99);

        $query = $this->Estagiarios->find();
        
        $adminQuery = $this->EstagiariosTablePolicy->scopeIndex($admin, clone $query);
        $this->assertEmpty($adminQuery->clause('where'));

        $alunoQuery = $this->EstagiariosTablePolicy->scopeIndex($aluno, clone $query);
        $this->assertNotEmpty($alunoQuery->clause('where'));

        $professorQuery = $this->EstagiariosTablePolicy->scopeIndex($professor, clone $query);
        $this->assertNotEmpty($professorQuery->clause('where'));

        $supervisorQuery = $this->EstagiariosTablePolicy->scopeIndex($supervisor, clone $query);
        $this->assertNotEmpty($supervisorQuery->clause('where'));

        $unknownQuery = $this->EstagiariosTablePolicy->scopeIndex($unknown, clone $query);
        $this->assertNotEmpty($unknownQuery->clause('where'));
    }

    public function testCanLancanota(): void
    {
        $professor = $this->getIdentity('3', 3);
        $aluno = $this->getIdentity('2', 2);
        
        $this->assertTrue($this->EstagiariosTablePolicy->canLancanota($professor, $this->Estagiarios)->getStatus());
        $this->assertFalse($this->EstagiariosTablePolicy->canLancanota($aluno, $this->Estagiarios)->getStatus());
    }

    public function testCanLancanotapdf(): void
    {
        $professor = $this->getIdentity('3', 3);
        $aluno = $this->getIdentity('2', 2);
        
        $this->assertTrue($this->EstagiariosTablePolicy->canLancanotapdf($professor, $this->Estagiarios)->getStatus());
        $this->assertFalse($this->EstagiariosTablePolicy->canLancanotapdf($aluno, $this->Estagiarios)->getStatus());
    }

    public function testCanBusca(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertFalse($this->EstagiariosTablePolicy->canBusca($aluno, $this->Estagiarios)->getStatus());
    }
}
