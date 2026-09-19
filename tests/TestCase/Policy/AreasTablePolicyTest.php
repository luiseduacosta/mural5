<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\AreasTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AreasTablePolicy Test Case
 */
class AreasTablePolicyTest extends TestCase
{
    /**
     * @var \App\Policy\AreasTablePolicy
     */
    protected $AreasTablePolicy;

    protected $Areas;

    protected array $fixtures = [
        'app.Users',
        'app.Areas',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->AreasTablePolicy = new AreasTablePolicy();
        $this->Areas = TableRegistry::getTableLocator()->get('Areas');
    }

    protected function tearDown(): void
    {
        unset($this->AreasTablePolicy, $this->Areas);
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
        $this->assertTrue($this->AreasTablePolicy->before($admin, $this->Areas, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->AreasTablePolicy->before($aluno, $this->Areas, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->AreasTablePolicy->before(null, $this->Areas, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->AreasTablePolicy->canIndex($aluno, $this->Areas)->getStatus());
        $this->assertFalse($this->AreasTablePolicy->canIndex(null, $this->Areas)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->AreasTablePolicy->canAdd($aluno, $this->Areas)->getStatus());
        $this->assertFalse($this->AreasTablePolicy->canAdd(null, $this->Areas)->getStatus());
    }
}
