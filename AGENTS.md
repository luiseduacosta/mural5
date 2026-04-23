# AGENTS.md

This file provides guidance to Qoder (qoder.com) when working with code in this repository.

## Project Overview

- **Type**: CakePHP 5 web application
- **Purpose**: Internship bulletin board for ESS/UFRJ
- **PHP Version**: >=8.1
- **Database**: MySQL/MariaDB
- **Plugins**: CakePdf (DomPDF engine), Authentication, Authorization, Migrations, DebugKit

## Build / Lint / Test Commands

```bash
composer test               # Run all tests
composer check              # Full check (test + cs-check)
composer cs-check           # Check code style
composer cs-fix             # Auto-fix code style
composer stan               # Static analysis (phpstan)

# Run single test file
vendor/bin/phpunit tests/TestCase/Controller/EstagiariosControllerTest.php

# Run specific test method
vendor/bin/phpunit --filter testView

# Run tests with coverage
vendor/bin/phpunit --coverage-html coverage
```

## High-Level Architecture

### Multi-Role User Model

The system has a single `users` table with a `categoria` field determining role:

| Categoria | Role |
|-----------|------|
| 1 | Administrador (Admin) |
| 2 | Aluno (Student) |
| 3 | Professor |
| 4 | Supervisor |

The `User` entity (`src/Model/Entity/User.php`) implements `Authentication\IdentityInterface` and provides role helper methods: `isAdmin()`, `isAluno()`, `isProfessor()`, `isSupervisor()`.

Crucially, `User::getOriginalData()` dynamically resolves foreign keys by querying related tables when they are null. For example, if `aluno_id` is not set on a student user, it looks up the `Alunos` table by `user_id` or `email` and populates the field. This means `$identity->getOriginalData()['aluno_id']` (and similar for `professor_id`, `supervisor_id`, `administrador_id`) is the reliable way to check a user's linked role entity in policies and controllers.

### Authentication & Login Flow

Authentication uses the CakePHP Authentication plugin with email/password via `Application::getAuthenticationService()`. The `UsersController::login()` method handles role-based redirection:

- **Students** (categoria 2): Redirected to `Alunos::view` after auto-linking to their `Alunos` record by email or `identificacao` (DRE).
- **Professors** (categoria 3): Redirected to `Professores::view` after auto-linking by email or `identificacao` (SIAPE).
- **Supervisors** (categoria 4): Redirected to `Supervisores::view` after auto-linking by email or `identificacao` (CRESS).
- **Admins** (categoria 1): Redirected to `Muralestagios::index`.

The `UsersController::add()` action also performs this linking during registration. The `UsersController::preencher()` method bulk-updates existing users to link them to their role entities.

### Authorization & Policies

Uses the CakePHP Authorization plugin with `OrmResolver`. The `AuthorizationMiddleware` is applied after `AuthenticationMiddleware` in the middleware stack.

**Policy File Types:**
- **`{Model}Policy.php`** - Entity policies (e.g., `EstagiarioPolicy.php`)
- **`{Model}TablePolicy.php`** - Table policies for index actions (e.g., `EstagiariosTablePolicy.php`)

**Policy Pattern:**
All entity policies should implement `BeforePolicyInterface`. The `before()` method grants admins immediate access:

```php
public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
{
    if ($identity && !empty($identity->getOriginalData()['administrador_id'])) {
        return true;
    }
    return null;
}
```

Standard policy methods: `canIndex()`, `canView()`, `canAdd()`, `canEdit()`, `canDelete()`. Custom action policies also exist (e.g., `canLancanota()`, `canTermoCompromisso()`).

Ownership checks in policies compare the resolved role ID from `getOriginalData()` against the resource's foreign key (e.g., `$user_data['professor_id'] === $estagiario->professor_id`).

Controllers load both `Authentication.Authentication` and `Authorization.Authorization` components in `AppController::initialize()`. Use `$this->Authorization->authorize($entity)` for entity checks and `$this->Authorization->skipAuthorization()` when authorization is not needed (e.g., login/logout). Use `$this->Authentication->addUnauthenticatedActions(['login', 'add'])` in `beforeFilter()` to allow public access.

### PDF Generation

PDFs are generated via the **CakePdf** plugin using the **DomPDF** engine (`config/app.php`). Controllers set PDF config on the view builder:

```php
$this->viewBuilder()->setOption('pdfConfig', [
    'filename' => 'document.pdf',
]);
```

PDF templates use `.ctp` files. The router accepts `.pdf` extension (`$routes->setExtensions(['pdf'])` in `config/routes.php`). Several controllers have dedicated PDF actions (e.g., `termodecompromisso()`, `avaliacaodiscentepdf()`, `folhadeatividadespdf()`, `certificadoperiodo()`).

### Period-Based Management

The `Configuracoes` table stores `mural_periodo_atual`, which is the default academic period for filtering. `AppController::initialize()` loads the configuration record into `$this->configuracao` and sets it for all views. Listing controllers (e.g., `EstagiariosController::index()`) default to this period if no `?periodo=` query parameter is provided.

### Middleware Stack

```
ErrorHandlerMiddleware
HostHeaderMiddleware      # Validates Host header in production; skipped in debug mode
AssetMiddleware
RoutingMiddleware
BodyParserMiddleware
AuthenticationMiddleware
AuthorizationMiddleware
CsrfProtectionMiddleware
```

`HostHeaderMiddleware` is a custom security middleware that prevents Host Header Injection by validating the `Host` header against `App.fullBaseUrl` in production.

## Code Style Guidelines

- Use `declare(strict_types=1);` at the top of PHP files
- Indentation: 4 spaces (not tabs), except YAML (2 spaces)
- Line endings: LF; final newline required

### Naming Conventions

- **Classes**: PascalCase (`UsersTable`, `EstagiariosController`)
- **Methods/Variables**: camelCase (`initialize()`, `$user`)
- **Constants**: UPPER_CASE
- **Files**: Match class name (`UsersTable.php`)
- **Tables**: Plural in DB, PascalCase for models

### PHPCS Configuration

- Uses PSR12 standard (`phpcs.xml`)
- Excludes: `PSR1.Methods`, `PSR2.Methods`, `PSR12.Files.FileHeader`
- `src/Model/Entity/User.php` is excluded from checks
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

## Testing

- Tests in `tests/TestCase/{Type}/` matching `src/` structure
- Test files: `{ClassName}Test.php`
- Fixtures in `tests/Fixture/`
- Uses PHPUnit 10 with CakePHP fixtures extension
- Test bootstrap (`tests/bootstrap.php`) uses `Migrations\TestSuite\Migrator` to build the test database schema from migrations automatically

## Configuration

- Database: `config/app_local.php`
- Environment: `config/.env`
- Routes: `config/routes.php`
- PHPCS: `phpcs.xml`
- PHPUnit: `phpunit.xml.dist`
