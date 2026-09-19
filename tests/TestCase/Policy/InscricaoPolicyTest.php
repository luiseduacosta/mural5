<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use App\Model\Entity\Aluno;
use App\Model\Entity\Inscricao;
use App\Model\Entity\User;
use App\Policy\InscricaoPolicy;
use Cake\TestSuite\TestCase;

/**
 * App\Policy\InscricaoPolicy Test Case
 */
class InscricaoPolicyTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Policy\InscricaoPolicy
     */
    protected $InscricaoPolicy;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->InscricaoPolicy = new InscricaoPolicy();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InscricaoPolicy);
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
        $aluno = $this->getIdentity('2', 2);

        $this->assertTrue($this->InscricaoPolicy->before($admin, new Inscricao(), 'view'));
        $this->assertNull($this->InscricaoPolicy->before($aluno, new Inscricao(), 'view'));
    }

    public function testCanView(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);
        $otherAluno = $this->getIdentity('2', 99);

        $resource = new Inscricao([
            'aluno' => new Aluno(['user_id' => $alunoId])
        ]);

        $this->assertTrue($this->InscricaoPolicy->canView($aluno, $resource)->getStatus());
        $this->assertFalse($this->InscricaoPolicy->canView($otherAluno, $resource)->getStatus());
    }

    public function testCanEdit(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);
        $otherAluno = $this->getIdentity('2', 99);

        $resource = new Inscricao([
            'aluno' => new Aluno(['user_id' => $alunoId])
        ]);

        $this->assertTrue($this->InscricaoPolicy->canEdit($aluno, $resource)->getStatus());
        $this->assertFalse($this->InscricaoPolicy->canEdit($otherAluno, $resource)->getStatus());
    }

    public function testCanDelete(): void
    {
        $alunoId = 2;
        $aluno = $this->getIdentity('2', $alunoId);

        $resource = new Inscricao([
            'aluno' => new Aluno(['user_id' => $alunoId])
        ]);

        $this->assertFalse($this->InscricaoPolicy->canDelete($aluno, $resource)->getStatus());
    }
}
