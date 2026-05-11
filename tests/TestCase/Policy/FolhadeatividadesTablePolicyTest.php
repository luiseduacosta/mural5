<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\User;
use App\Policy\FolhadeatividadesTablePolicy;
use Authorization\AuthorizationService;
use Authorization\Identity;
use Authorization\IdentityInterface;
use Authorization\Policy\OrmResolver;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\FolhadeatividadesTablePolicy Test Case
 */
class FolhadeatividadesTablePolicyTest extends TestCase
{
    protected $FolhadeatividadesTablePolicy;
    protected $Folhadeatividades;

    protected array $fixtures = [
        'app.Users',
        'app.Folhadeatividades',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->FolhadeatividadesTablePolicy = new FolhadeatividadesTablePolicy();
        $this->Folhadeatividades = TableRegistry::getTableLocator()->get('Folhadeatividades');
    }

    protected function tearDown(): void
    {
        unset($this->FolhadeatividadesTablePolicy, $this->Folhadeatividades);
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
        $this->assertTrue($this->FolhadeatividadesTablePolicy->before($admin, $this->Folhadeatividades, 'index'));
    }

    public function testBeforeNonAdmin(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertNull($this->FolhadeatividadesTablePolicy->before($aluno, $this->Folhadeatividades, 'index'));
    }

    public function testCanIndex(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->FolhadeatividadesTablePolicy->canIndex($aluno, $this->Folhadeatividades)->getStatus());
        $this->assertFalse($this->FolhadeatividadesTablePolicy->canIndex(null, $this->Folhadeatividades)->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 2);
        $this->assertTrue($this->FolhadeatividadesTablePolicy->canAdd($aluno, $this->Folhadeatividades)->getStatus());
        $this->assertFalse($this->FolhadeatividadesTablePolicy->canAdd(null, $this->Folhadeatividades)->getStatus());
    }
}
