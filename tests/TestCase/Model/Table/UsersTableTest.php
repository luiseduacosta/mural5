<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    protected array $fixtures = [];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $validator = $this->Users->validationDefault(new \Cake\Validation\Validator());

        // Test valid data passes validation
        $errors = $validator->validate([
            'email' => 'test@example.com',
            'password' => 'test123',
            'categoria' => '1',
        ]);
        $this->assertEmpty($errors);

        // Test empty email fails
        $errors = $validator->validate([
            'email' => '',
            'password' => 'test123',
            'categoria' => '1',
        ]);
        $this->assertArrayHasKey('email', $errors);

        // Test invalid email format
        $errors = $validator->validate([
            'email' => 'invalid-email',
            'password' => 'test123',
            'categoria' => '1',
        ]);
        $this->assertArrayHasKey('email', $errors);

        // Test invalid categoria
        $errors = $validator->validate([
            'email' => 'test@example.com',
            'password' => 'test123',
            'categoria' => '5',
        ]);
        $this->assertArrayHasKey('categoria', $errors);

        // Test valid categoria values
        foreach (['1', '2', '3', '4'] as $cat) {
            $errors = $validator->validate([
                'email' => 'test@example.com',
                'password' => 'test123',
                'categoria' => $cat,
            ]);
            $this->assertArrayNotHasKey('categoria', $errors, "Categoria $cat should be valid");
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $rules = $this->Users->buildRules(new \Cake\ORM\RulesChecker());

        $this->assertInstanceOf(\Cake\ORM\RulesChecker::class, $rules);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->assertSame('users', $this->Users->getTable());
        $this->assertSame('Users', $this->Users->getAlias());
        $this->assertSame('email', $this->Users->getDisplayField());
        $this->assertSame('id', $this->Users->getPrimaryKey());
    }
}
