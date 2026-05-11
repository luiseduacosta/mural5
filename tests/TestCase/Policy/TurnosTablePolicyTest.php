<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\TurnosTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\TurnosTablePolicy Test Case
 */
class TurnosTablePolicyTest extends TestCase
{
    protected $TurnosTablePolicy;
    protected $Turnos;

    protected array $fixtures = [
        'app.Users',
        'app.Turnos',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->TurnosTablePolicy = new TurnosTablePolicy();
        $this->Turnos = TableRegistry::getTableLocator()->get('Turnos');
    }

    protected function tearDown(): void
    {
        unset($this->TurnosTablePolicy, $this->Turnos);
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
        $this->assertTrue($this->TurnosTablePolicy->before($admin, $this->Turnos, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->TurnosTablePolicy->before($aluno, $this->Turnos, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->TurnosTablePolicy->canIndex($aluno, $this->Turnos)->getStatus());
        $this->assertFalse($this->TurnosTablePolicy->canIndex(null, $this->Turnos)->getStatus());
    }
}
