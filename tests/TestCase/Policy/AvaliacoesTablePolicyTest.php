<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\AvaliacoesTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\AvaliacoesTablePolicy Test Case
 */
class AvaliacoesTablePolicyTest extends TestCase
{
    protected $AvaliacoesTablePolicy;
    protected $Avaliacoes;

    protected array $fixtures = [
        'app.Users',
        'app.Avaliacoes',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->AvaliacoesTablePolicy = new AvaliacoesTablePolicy();
        $this->Avaliacoes = TableRegistry::getTableLocator()->get('Avaliacoes');
    }

    protected function tearDown(): void
    {
        unset($this->AvaliacoesTablePolicy, $this->Avaliacoes);
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
        $this->assertTrue($this->AvaliacoesTablePolicy->before($admin, $this->Avaliacoes, 'index'));
    }

    public function testBeforeSupervisor(): void
    {
        $supervisor = $this->makeIdentity(['id' => 4, 'categoria' => '4', 'supervisor_id' => 4]);
        $this->assertTrue($this->AvaliacoesTablePolicy->before($supervisor, $this->Avaliacoes, 'index'));
    }

    public function testBeforeAluno(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2', 'supervisor_id' => null]);
        $this->assertNull($this->AvaliacoesTablePolicy->before($aluno, $this->Avaliacoes, 'index'));
    }

    public function testBeforeNullIdentity(): void
    {
        $this->assertNull($this->AvaliacoesTablePolicy->before(null, $this->Avaliacoes, 'index'));
    }

    public function testCanIndexForAllRoles(): void
    {
        foreach (['1', '2', '3', '4'] as $categoria) {
            $identity = $this->makeIdentity(['id' => 1, 'categoria' => $categoria]);
            $this->assertTrue(
                $this->AvaliacoesTablePolicy->canIndex($identity, $this->Avaliacoes)->getStatus(),
                "Expected canIndex true for categoria {$categoria}"
            );
        }
    }

    public function testCanIndexInvalidCategoria(): void
    {
        $identity = $this->makeIdentity(['id' => 1, 'categoria' => '9']);
        $this->assertFalse($this->AvaliacoesTablePolicy->canIndex($identity, $this->Avaliacoes)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->makeIdentity(['id' => 2, 'categoria' => '2']);
        $this->assertTrue($this->AvaliacoesTablePolicy->canAdd($aluno, $this->Avaliacoes)->getStatus());
        $this->assertFalse($this->AvaliacoesTablePolicy->canAdd(null, $this->Avaliacoes)->getStatus());
    }
}
