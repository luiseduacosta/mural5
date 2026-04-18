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
composer test                       # Run all tests
vendor/bin/phpunit path/to/Test.php # Run single test file
vendor/bin/phpunit --filter method  # Run specific test method
composer cs-check                   # Check code style
composer cs-fix                     # Auto-fix code style
composer check                      # Full check (test + cs-check)
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
// Controller
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

// Table
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

- Use explicit `use` statements; sort alphabetically

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

- Tests in `tests/TestCase/{Type}/` matching src structure
- Name: `{ClassName}Test.php`; fixtures in `tests/Fixture/`

## Configuration

- Database: `config/app_local.php`
- Environment: `config/.env`
- Routes: `config/routes.php`

## Authorization / Policies

The project uses CakePHP Authorization plugin with these user categories:

| Categoria | Role |
|-----------|------|
| 1 | Administrador (Admin) |
| 2 | Aluno (Student) |
| 3 | Professor |
| 4 | Supervisor |

### Policy File Types

- **`{Model}Policy.php`** - Entity policies (e.g., `UserPolicy.php`)
- **`{Model}TablePolicy.php`** - Table policies for index (e.g., `UsersTablePolicy.php`)

### Policy Methods

- `canIndex()`, `canView()`, `canAdd()`, `canEdit()`, `canDelete()`
- Custom: `canCargaHoraria()`, `canDeclaracaoperiodo()`, etc.

### Policy Examples

```php
// Admin only
public function canDelete(?IdentityInterface $user, User $resource)
{
    return isset($user) && $user->getOriginalData()->isAdmin();
}

// Category check
public function canAdd(?IdentityInterface $user, Estagiario $estagiario)
{
    return isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2');
}

// Ownership check
protected function isAuthor(?IdentityInterface $user, Aluno $aluno)
{
    return $aluno->id === $user->aluno_id;
}
```

### Checking User Roles

```php
// Via categoria field
$user->categoria == '1'  // Admin

// Via entity methods
$user->getOriginalData()->isAdmin();
$user->getOriginalData()->isAluno();
$user->getOriginalData()->isProfessor();
$user->getOriginalData()->isSupervisor();
```
