<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\InstituicoesTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\InstituicoesTablePolicy Test Case
 */
class InstituicoesTablePolicyTest extends TestCase
{
    protected $InstituicoesTablePolicy;
    protected $Instituicoes;

    protected array $fixtures = [
        'app.Users',
        'app.Instituicoes',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->InstituicoesTablePolicy = new InstituicoesTablePolicy();
        $this->Instituicoes = TableRegistry::getTableLocator()->get('Instituicoes');
    }

    protected function tearDown(): void
    {
        unset($this->InstituicoesTablePolicy, $this->Instituicoes);
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
        $this->assertTrue($this->InstituicoesTablePolicy->before($admin, $this->Instituicoes, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->InstituicoesTablePolicy->before($aluno, $this->Instituicoes, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->InstituicoesTablePolicy->canIndex($aluno, $this->Instituicoes)->getStatus());
        $this->assertFalse($this->InstituicoesTablePolicy->canIndex(null, $this->Instituicoes)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->InstituicoesTablePolicy->canAdd($aluno, $this->Instituicoes)->getStatus());
        $this->assertFalse($this->InstituicoesTablePolicy->canAdd(null, $this->Instituicoes)->getStatus());
    }
}
