<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

class UsersTableTest extends TestCase
{
    protected $Users;

    protected array $fixtures = [
        'app.Users',
        'app.Categorias',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    public function tearDown(): void
    {
        unset($this->Users);
        parent::tearDown();
    }

    public function testInitialize(): void
    {
        $this->assertSame('users', $this->Users->getTable());
        $this->assertSame('Users', $this->Users->getAlias());
        $this->assertSame('email', $this->Users->getDisplayField());
        $this->assertSame('id', $this->Users->getPrimaryKey());
    }

    public function testValidationDefault(): void
    {
        $validator = $this->Users->validationDefault(new \Cake\Validation\Validator());

        $errors = $validator->validate([
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'test123',
            'categoria' => '2',
        ]);
        $this->assertEmpty($errors, 'Valid data should pass: ' . print_r($errors, true));

        $errors = $validator->validate([
            'nome' => 'Test User',
            'email' => '',
            'password' => 'test123',
            'categoria' => '2',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Empty email should fail');

        $errors = $validator->validate([
            'nome' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'test123',
            'categoria' => '2',
        ]);
        $this->assertArrayHasKey('email', $errors, 'Invalid email format should fail');

        $errors = $validator->validate([
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'test123',
            'categoria' => '5',
        ]);
        $this->assertArrayHasKey('categoria', $errors, 'Invalid categoria should fail');

        foreach (['1', '2', '3', '4'] as $cat) {
            $errors = $validator->validate([
                'nome' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'test123',
                'categoria' => $cat,
            ]);
            $this->assertArrayNotHasKey('categoria', $errors, "Categoria $cat should be valid");
        }
    }

    public function testBuildRules(): void
    {
        $rules = $this->Users->buildRules(new \Cake\ORM\RulesChecker());
        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }
}