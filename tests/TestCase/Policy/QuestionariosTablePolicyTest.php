<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\QuestionariosTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\QuestionariosTablePolicy Test Case
 */
class QuestionariosTablePolicyTest extends TestCase
{
    protected $QuestionariosTablePolicy;
    protected $Questionarios;

    protected array $fixtures = [
        'app.Users',
        'app.Questionarios',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->QuestionariosTablePolicy = new QuestionariosTablePolicy();
        $this->Questionarios = TableRegistry::getTableLocator()->get('Questionarios');
    }

    protected function tearDown(): void
    {
        unset($this->QuestionariosTablePolicy, $this->Questionarios);
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
        $this->assertTrue($this->QuestionariosTablePolicy->before($admin, $this->Questionarios, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertNull($this->QuestionariosTablePolicy->before($aluno, $this->Questionarios, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->QuestionariosTablePolicy->before(null, $this->Questionarios, 'index'));
    }

    public function testCanIndexAdmin(): void
    {
        $admin = $this->makeIdentity(['id' => 1, 'categoria' => '1']);
        $this->assertTrue($this->QuestionariosTablePolicy->canIndex($admin, $this->Questionarios)->getStatus());
    }

    public function testCanIndexDenied(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertFalse($this->QuestionariosTablePolicy->canIndex($aluno, $this->Questionarios)->getStatus());
        $this->assertFalse($this->QuestionariosTablePolicy->canIndex(null, $this->Questionarios)->getStatus());
    }
}
