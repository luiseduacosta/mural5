# AGENTS.md - Mural de Estágios (CakePHP 5)

Guidelines for agentic coding agents working in this repository.

## Project Overview

- **Type**: CakePHP 5 web application
- **Purpose**: Internship bulletin board for ESS/UFRJ
- **PHP Version**: >=8.1
- **Database**: MySQL/MariaDB

## Directory Structure

```
src/
├── Application.php       # Main application bootstrap
├── Controller/          # CakePHP controllers (extends AppController)
├── Model/Table/         # CakePHP Table classes
├── Model/Entity/        # CakePHP Entity classes
├── Policy/             # Authorization policies
├── View/Helper/        # View helpers
├── Middleware/         # Custom middleware
└── Console/            # Console commands
tests/TestCase/        # Unit/integration tests
tests/Fixture/          # Database fixtures
config/                 # Application configuration
templates/              # View templates (.ctp)
```

## Build / Lint / Test Commands

```bash
# Run all tests
composer test

# Run a single test file
vendor/bin/phpunit tests/TestCase/ApplicationTest.php

# Run a specific test method
vendor/bin/phpunit tests/TestCase/ApplicationTest.php --filter testBootstrap

# Check code style
composer cs-check

# Auto-fix code style issues
composer cs-fix

# Full check (test + cs-check)
composer check
```

## Code Style Guidelines

- Use PHP 8.1+ features (named arguments, readonly properties)
- Always use `declare(strict_types=1);` at the top of PHP files
- Indentation: 4 spaces (not tabs), except YAML (2 spaces)
- Line endings: LF; final newline required

### Naming

- **Classes**: PascalCase (`UsersTable`, `EstagiariosController`)
- **Methods/Variables**: camelCase (`initialize()`, `$user`)
- **Constants**: UPPER_CASE
- **Files**: Match class name (`UsersTable.php`)
- **Tables**: Plural in DB, PascalCase for models

### Code Examples

```php
class AppController extends Controller
{
    protected $user;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->user = $this->request->getAttribute('identity');
        $this->set('user', $this->user);
    }
}
```

### Tables

```php
class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('users');
        $this->setAlias('Users');
        $this->setDisplayField('email');
        $this->setPrimaryKey('id');
        $this->belongsTo('Alunos', ['foreignKey' => 'aluno_id']);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer('id')->allowEmptyString('id', null, 'create');
        return $validator;
    }
}
```

### Imports

- Use explicit `use` statements
- Sort alphabetically within groups

### Types

- Use PHP 8 native return types (`void`, `int`, `string`)
- Use union types where appropriate (`int|string`)

### Error Handling

- Use CakePHP exceptions: `NotFoundException`, `ForbiddenException`
- Flash messages: `$this->Flash->success/error/warning/info()`

### PHPCS

- Uses CakePHP coding standard (see `phpcs.xml`)
- Controllers exempt from return type hints
- Run `composer cs-fix` to auto-apply fixes

## Testing

- Place tests in `tests/TestCase/{Type}/` matching src structure
- Name: `{ClassName}Test.php`
- Fixtures in `tests/Fixture/`

## Configuration

- Database: `config/app_local.php`
- Environment: `config/.env`
- Routes: `config/routes.php`

## Common Tasks

```bash
# Bake controller
bin/cake bake controller Users

# Bake model
bin/cake bake model Users

# Run migrations
bin/cake migrations migrate
bin/cake migrations rollback
```
