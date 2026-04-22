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
├── Application.php           # Main application bootstrap
├── Controller/              # CakePHP controllers (extends AppController)
├── Model/Table/            # CakePHP Table classes
├── Model/Entity/            # CakePHP Entity classes
├── Policy/                  # Authorization policies
├── View/Helper/             # View helpers
├── Middleware/              # Custom middleware
├── Console/                 # Console commands
tests/TestCase/             # Unit/integration tests
tests/Fixture/              # Database fixtures
config/                    # Application configuration
templates/                 # View templates (.ctp)
```

## Build / Lint / Test Commands

```bash
composer test               # Run all tests
composer check              # Full check (test + cs-check)
composer cs-check           # Check code style
composer cs-fix             # Auto-fix code style
composer stan               # Static analysis

# Run single test file
vendor/bin/phpunit tests/TestCase/Controller/EstagiariosControllerTest.php

# Run specific test method
vendor/bin/phpunit --filter testView

# Run tests with coverage
vendor/bin/phpunit --coverage-html coverage
```

## Code Style Guidelines

- Use PHP 8.1+ features (named arguments, readonly properties)
- Always use `declare(strict_types=1);` at the top of PHP files
- Indentation: 4 spaces (not tabs), except YAML (2 spaces)
- Line endings: LF; final newline required

### Naming Conventions

- **Classes**: PascalCase (`UsersTable`, `EstagiariosController`)
- **Methods/Variables**: camelCase (`initialize()`, `$user`)
- **Constants**: UPPER_CASE
- **Files**: Match class name (`UsersTable.php`)
- **Tables**: Plural in DB, PascalCase for models

### PHPCS Configuration

- Uses PSR12 standard (see `phpcs.xml`)
- Excludes: `PSR1.Methods`, `PSR2.Methods`, `PSR12.Files.FileHeader`
- User entity excluded: `src/Model/Entity/User.php`
- Run `composer cs-fix` to auto-apply fixes

### Imports

- Use explicit `use` statements; sort alphabetically
- Group by: internal CakePHP, external packages, app imports

### Types

- Use PHP 8 native return types (`void`, `int`, `string`)
- Use union types where appropriate (`int|string`)

### Error Handling

- Use CakePHP exceptions: `NotFoundException`, `ForbiddenException`
- Flash messages: `$this->Flash->success/error/warning/info()`
- Policy methods return `Result` from Authorization plugin

## Authorization / Policies

The project uses CakePHP Authorization plugin with these user categories:

| Categoria | Role |
|-----------|------|
| 1 | Administrador (Admin) |
| 2 | Aluno (Student) |
| 3 | Professor |
| 4 | Supervisor |

### Policy File Types

- **`{Model}Policy.php`** - Entity policies (e.g., `EstagiarioPolicy.php`)
- **`{Model}TablePolicy.php`** - Table policies for index (e.g., `EstagiariosTablePolicy.php`)

### Policy Methods

- Standard: `canIndex()`, `canView()`, `canAdd()`, `canEdit()`, `canDelete()`
- Custom: `canLancanota()`, `canTermoCompromisso()`, etc.

### Checking User Roles

```php
// Via IdentityInterface
$user_data = $identity->getOriginalData();
$user_data['categoria'] == '1'  // Admin
$user_data['administrador_id']  // Non-null if admin
$user_data['professor_id']      // Non-null if professor
$user_data['supervisor_id']     // Non-null if supervisor
$user_data['aluno_id']          // Non-null if student
```

### Policy Example

```php
final class EstagiarioPolicy implements BeforePolicyInterface
{
    public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
    {
        if ($identity && !empty($identity->getOriginalData()['administrador_id'])) {
            return true;
        }
        return null;
    }

    public function canView(IdentityInterface $userSession, Estagiario $estagiario): Result
    {
        $user_data = $userSession->getOriginalData();
        if (isset($user_data['professor_id']) && $user_data['professor_id'] === $estagiario->professor_id) {
            return new Result(true);
        }
        return new Result(false, 'Not authorized');
    }
}
```

## Testing

- Tests in `tests/TestCase/{Type}/` matching src structure
- Test files: `{ClassName}Test.php`
- Fixtures in `tests/Fixture/`
- Uses PHPUnit 10 with CakePHP fixtures extension

## Configuration

- Database: `config/app_local.php`
- Environment: `config/.env`
- Routes: `config/routes.php`
- PHPCS: `phpcs.xml`
- PHPUnit: `phpunit.xml.dist`