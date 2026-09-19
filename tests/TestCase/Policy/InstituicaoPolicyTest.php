<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Instituicao;
use App\Model\Entity\User;
use App\Policy\InstituicaoPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\InstituicaoPolicy Test Case
 */
class InstituicaoPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\InstituicaoPolicy
     */
    protected $InstituicaoPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->InstituicaoPolicy = new InstituicaoPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InstituicaoPolicy);
        parent::tearDown();
    }

    protected function getIdentity(string $categoria, int $id): \Authorization\IdentityInterface
    {
        $data = [
            'id' => $id,
            'categoria' => $categoria,
            'entidade_id' => $id,
        ];
        
        if ($categoria === '2') {
            $data['aluno_id'] = $id;
        } elseif ($categoria === '3') {
            $data['professor_id'] = $id;
        } elseif ($categoria === '4') {
            $data['supervisor_id'] = $id;
        }

        $user = new User($data);
        $user->set('_fk_resolved', true);
        $service = new \Authorization\AuthorizationService(new \Authorization\Policy\OrmResolver());
        return new \Authorization\Identity($service, $user);
    }

    public function testBefore(): void
    {
        $admin = $this->getIdentity('1', 1);
        $professor = $this->getIdentity('3', 2);
        $aluno = $this->getIdentity('2', 3);

        $this->assertTrue($this->InstituicaoPolicy->before($admin, new Instituicao(), 'view'));
        
        // Professor bypasses all EXCEPT delete
        $this->assertTrue($this->InstituicaoPolicy->before($professor, new Instituicao(), 'view'));
        $this->assertTrue($this->InstituicaoPolicy->before($professor, new Instituicao(), 'edit'));
        $this->assertNull($this->InstituicaoPolicy->before($professor, new Instituicao(), 'delete'));
        
        $this->assertNull($this->InstituicaoPolicy->before($aluno, new Instituicao(), 'view'));
    }

    public function testCanView(): void
    {
        $aluno = $this->getIdentity('2', 3);
        $this->assertTrue($this->InstituicaoPolicy->canView($aluno, new Instituicao())->getStatus());
    }

    public function testCanAdd(): void
    {
        $aluno = $this->getIdentity('2', 3);
        $supervisor = $this->getIdentity('4', 4);
        
        $this->assertFalse($this->InstituicaoPolicy->canAdd($aluno, new Instituicao())->getStatus());
        $this->assertFalse($this->InstituicaoPolicy->canAdd($supervisor, new Instituicao())->getStatus());
    }

    public function testCanEdit(): void
    {
        $aluno = $this->getIdentity('2', 3);
        
        $supervisorId = 4;
        $supervisor = $this->getIdentity('4', $supervisorId);
        
        $otherSupervisor = $this->getIdentity('4', 99);

        $instituicao = new Instituicao([
            'supervisor_id' => [$supervisorId, 5, 6]
        ]);

        // Supervisor of the institution can edit
        $this->assertTrue($this->InstituicaoPolicy->canEdit($supervisor, $instituicao)->getStatus());
        
        // Unrelated supervisor cannot edit
        $this->assertFalse($this->InstituicaoPolicy->canEdit($otherSupervisor, $instituicao)->getStatus());
        
        // Aluno cannot edit
        $this->assertFalse($this->InstituicaoPolicy->canEdit($aluno, $instituicao)->getStatus());
    }

    public function testCanDelete(): void
    {
        $aluno = $this->getIdentity('2', 3);
        $professor = $this->getIdentity('3', 2); // Professor doesn't bypass delete
        
        $this->assertFalse($this->InstituicaoPolicy->canDelete($aluno, new Instituicao())->getStatus());
        $this->assertFalse($this->InstituicaoPolicy->canDelete($professor, new Instituicao())->getStatus());
    }
}
