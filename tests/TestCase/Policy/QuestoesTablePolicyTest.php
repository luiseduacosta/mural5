<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\QuestoesTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\QuestoesTablePolicy Test Case
 */
class QuestoesTablePolicyTest extends TestCase
{
    protected $QuestoesTablePolicy;
    protected $Questoes;

    protected array $fixtures = [
        'app.Users',
        'app.Questionarios',
        'app.Questoes',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->QuestoesTablePolicy = new QuestoesTablePolicy();
        $this->Questoes = TableRegistry::getTableLocator()->get('Questoes');
    }

    protected function tearDown(): void
    {
        unset($this->QuestoesTablePolicy, $this->Questoes);
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
        $this->assertTrue($this->QuestoesTablePolicy->before($admin, $this->Questoes, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->QuestoesTablePolicy->before($aluno, $this->Questoes, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->QuestoesTablePolicy->before(null, $this->Questoes, 'index'));
    }

    public function testCanIndexAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestoesTablePolicy->canIndex($admin, $this->Questoes)->getStatus());
    }

    public function testCanIndexDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestoesTablePolicy->canIndex($aluno, $this->Questoes)->getStatus());
        $this->assertFalse($this->QuestoesTablePolicy->canIndex(null, $this->Questoes)->getStatus());
    }
}
