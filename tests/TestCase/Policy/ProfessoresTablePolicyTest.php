<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\ProfessoresTablePolicy;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\ProfessoresTablePolicy Test Case
 */
class ProfessoresTablePolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\ProfessoresTablePolicy
     */
    protected $ProfessoresTablePolicy;

    /**
     * @var \App\Model\Table\ProfessoresTable
     */
    protected $Professores;

    protected array $fixtures = [
        'app.Users',
        'app.Professores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->ProfessoresTablePolicy = new ProfessoresTablePolicy();
        $this->Professores = TableRegistry::getTableLocator()->get('Professores');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProfessoresTablePolicy);
        unset($this->Professores);
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

        $this->assertTrue($this->ProfessoresTablePolicy->before($admin, $this->Professores, 'index'));
        $this->assertNull($this->ProfessoresTablePolicy->before($aluno, $this->Professores, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        
        $this->assertFalse($this->ProfessoresTablePolicy->canIndex($aluno, $this->Professores)->getStatus());
    }
}
