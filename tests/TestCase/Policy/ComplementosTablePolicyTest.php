<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\ComplementosTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\ComplementosTablePolicy Test Case
 */
class ComplementosTablePolicyTest extends TestCase
{
    protected $ComplementosTablePolicy;
    protected $Complementos;

    protected array $fixtures = [
        'app.Users',
        'app.Complementos',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->ComplementosTablePolicy = new ComplementosTablePolicy();
        $this->Complementos = TableRegistry::getTableLocator()->get('Complementos');
    }

    protected function tearDown(): void
    {
        unset($this->ComplementosTablePolicy, $this->Complementos);
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
        $this->assertTrue($this->ComplementosTablePolicy->before($admin, $this->Complementos, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->ComplementosTablePolicy->before($aluno, $this->Complementos, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->ComplementosTablePolicy->canIndex($aluno, $this->Complementos)->getStatus());
        $this->assertFalse($this->ComplementosTablePolicy->canIndex(null, $this->Complementos)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->ComplementosTablePolicy->canAdd($aluno, $this->Complementos)->getStatus());
        $this->assertFalse($this->ComplementosTablePolicy->canAdd(null, $this->Complementos)->getStatus());
    }
}
