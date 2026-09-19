<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\VisitasTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\VisitasTablePolicy Test Case
 */
class VisitasTablePolicyTest extends TestCase
{
    protected $VisitasTablePolicy;
    protected $Visitas;

    protected array $fixtures = [
        'app.Users',
        'app.Visitas',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->VisitasTablePolicy = new VisitasTablePolicy();
        $this->Visitas = TableRegistry::getTableLocator()->get('Visitas');
    }

    protected function tearDown(): void
    {
        unset($this->VisitasTablePolicy, $this->Visitas);
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
        $this->assertTrue($this->VisitasTablePolicy->before($admin, $this->Visitas, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->VisitasTablePolicy->before($aluno, $this->Visitas, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->VisitasTablePolicy->canIndex($aluno, $this->Visitas)->getStatus());
        $this->assertFalse($this->VisitasTablePolicy->canIndex(null, $this->Visitas)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->VisitasTablePolicy->canAdd($aluno, $this->Visitas)->getStatus());
        $this->assertFalse($this->VisitasTablePolicy->canAdd(null, $this->Visitas)->getStatus());
    }
}
