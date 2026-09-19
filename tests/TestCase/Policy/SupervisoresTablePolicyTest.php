<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\SupervisoresTablePolicy;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\SupervisoresTablePolicy Test Case
 */
class SupervisoresTablePolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\SupervisoresTablePolicy
     */
    protected $SupervisoresTablePolicy;

    /**
     * @var \Cake\ORM\Table
     */
    protected $Supervisores;

    protected array $fixtures = [
        'app.Users',
        'app.Supervisores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->SupervisoresTablePolicy = new SupervisoresTablePolicy();
        $this->Supervisores = TableRegistry::getTableLocator()->get('Supervisores');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SupervisoresTablePolicy);
        unset($this->Supervisores);
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

        $this->assertTrue($this->SupervisoresTablePolicy->before($admin, $this->Supervisores, 'index'));
        $this->assertNull($this->SupervisoresTablePolicy->before($aluno, $this->Supervisores, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        
        $this->assertTrue($this->SupervisoresTablePolicy->canIndex($aluno, $this->Supervisores)->getStatus());
        $this->assertFalse($this->SupervisoresTablePolicy->canIndex(null, $this->Supervisores)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        
        $this->assertTrue($this->SupervisoresTablePolicy->canAdd($aluno, $this->Supervisores)->getStatus());
        $this->assertFalse($this->SupervisoresTablePolicy->canAdd(null, $this->Supervisores)->getStatus());
    }
}
