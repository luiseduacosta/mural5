<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\TurmasTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\TurmasTablePolicy Test Case
 */
class TurmasTablePolicyTest extends TestCase
{
    protected $TurmasTablePolicy;
    protected $Turmas;

    protected array $fixtures = [
        'app.Users',
        'app.Turmas',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->TurmasTablePolicy = new TurmasTablePolicy();
        $this->Turmas = TableRegistry::getTableLocator()->get('Turmas');
    }

    protected function tearDown(): void
    {
        unset($this->TurmasTablePolicy, $this->Turmas);
        parent::tearDown();
    }

    protected function getIdentity(string $categoria, int $id): IdentityInterface
    {
        $user = new User(['id' => $id, 'categoria' => $categoria, 'entidade_id' => $id]);
        $user->set('_fk_resolved', true);
        $service = new AuthorizationService(new OrmResolver());
        return new Identity($service, $user);
    }

    public function testBeforeAdmin(): void
    {
        $admin = $this->getIdentity('1', 1);
        $this->assertTrue($this->TurmasTablePolicy->before($admin, $this->Turmas, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->TurmasTablePolicy->before($aluno, $this->Turmas, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->TurmasTablePolicy->canIndex($aluno, $this->Turmas)->getStatus());
        $this->assertFalse($this->TurmasTablePolicy->canIndex(null, $this->Turmas)->getStatus());
    }
}
