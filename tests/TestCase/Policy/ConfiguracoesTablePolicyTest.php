<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\ConfiguracoesTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\ConfiguracoesTablePolicy Test Case
 */
class ConfiguracoesTablePolicyTest extends TestCase
{
    protected $ConfiguracoesTablePolicy;
    protected $Configuracoes;

    protected array $fixtures = [
        'app.Users',
        'app.Configuracoes',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->ConfiguracoesTablePolicy = new ConfiguracoesTablePolicy();
        $this->Configuracoes = TableRegistry::getTableLocator()->get('Configuracoes');
    }

    protected function tearDown(): void
    {
        unset($this->ConfiguracoesTablePolicy, $this->Configuracoes);
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
        $this->assertTrue($this->ConfiguracoesTablePolicy->before($admin, $this->Configuracoes, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->ConfiguracoesTablePolicy->before($aluno, $this->Configuracoes, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->ConfiguracoesTablePolicy->canIndex($aluno, $this->Configuracoes)->getStatus());
        $this->assertFalse($this->ConfiguracoesTablePolicy->canIndex(null, $this->Configuracoes)->getStatus());
    }

    public function testCanAddDenied(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertFalse($this->ConfiguracoesTablePolicy->canAdd($aluno, $this->Configuracoes)->getStatus());
    }
}
