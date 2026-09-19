# Mural de Estágios - ESS/UFRJ

## Overview

The **Mural de Estágios** is a web-based internship bulletin board system developed for the **Escola de Serviço Social (ESS)** at **Universidade Federal do Rio de Janeiro (UFRJ)**. Built with **CakePHP 5.x**, it manages the entire internship lifecycle from posting opportunities to tracking student progress and generating evaluation reports.

---

## Table of Contents

1. [Architecture](#architecture)
2. [User Roles & Authorization](#user-roles--authorization)
3. [Core Modules](#core-modules)
4. [Database Schema](#database-schema)
5. [Key Features](#key-features)
6. [Installation](#installation)
7. [Configuration](#configuration)
8. [API Endpoints](#api-endpoints)

---

## Architecture

### Technology Stack

| Component | Technology |
|-----------|------------|
| Framework | CakePHP 5.x |
| Language | PHP 8.1+ |
| Database | MySQL/MariaDB |
| Frontend | Bootstrap 5, jQuery |
| PDF Generation | CakePdf (DomPDF) |
| Authentication | CakePHP Authentication Plugin |
| Authorization | CakePHP Authorization Plugin (Policy-based) |

### Directory Structure

```
mural5/
├── bin/                    # CakePHP console scripts
├── config/                 # Configuration files
│   ├── app.php            # Main application config
│   ├── app_local.php      # Local environment config
│   ├── routes.php         # URL routing
│   └── Migrations/        # Database migrations
├── src/                   # Application source code
│   ├── Controller/        # 24 Controllers
│   ├── Middleware/        # Custom middleware (HostHeader)
│   ├── Model/
│   │   ├── Entity/        # Data entities
│   │   └── Table/         # 21 Table models
│   └── View/              # View classes
├── templates/             # View templates (27 directories)
├── webroot/               # Public assets
│   ├── css/
│   ├── js/
│   └── img/
├── tests/                 # PHPUnit test suite
└── plugins/               # CakePHP plugins
```

---

## User Roles & Authorization

The system implements **Role-Based Access Control (RBAC)** with four distinct user categories stored in the `users.categoria` field:

| Role | Categoria | Description | Key Permissions |
|------|-----------|-------------|-----------------|
| **Administrator** | 1 | System administrators | Full access to all modules |
| **Student** (Aluno) | 2 | Internship students | View opportunities, submit applications, track progress |
| **Professor** | 3 | Faculty supervisors | Evaluate students, manage visits |
| **Supervisor** | 4 | Field supervisors | Evaluate intern performance |

### User Entity & Role Helpers

The `User` entity implements `Authentication\IdentityInterface` and provides role-checking methods:

```php
$user->isAdmin()      // categoria == 1
$user->isAluno()      // categoria == 2
$user->isProfessor()  // categoria == 3
$user->isSupervisor() // categoria == 4
```

The `User::getOriginalData()` method dynamically resolves foreign keys (e.g., `aluno_id`, `professor_id`, `supervisor_id`, `administrador_id`) by querying related tables when they are null. This makes `$identity->getOriginalData()['aluno_id']` the reliable way to check a user's linked role entity.

### Policy-Based Authorization

Authorization uses the CakePHP Authorization plugin with `OrmResolver`. Policies are defined in two forms:

- **Entity Policies** (`{Model}Policy.php`): Check access to individual records.
- **Table Policies** (`{Model}TablePolicy.php`): Check access to index/listing actions.

All entity policies implement `BeforePolicyInterface` to grant admins immediate access:

```php
public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
{
    if ($identity && !empty($identity->getOriginalData()['administrador_id'])) {
        return true;
    }
    return null;
}
```

Standard policy methods: `canIndex()`, `canView()`, `canAdd()`, `canEdit()`, `canDelete()`.

Controllers authorize with:

```php
$this->Authorization->authorize($entity);
$this->Authorization->skipAuthorization(); // when not needed (e.g., login)
```

---

## Core Modules

### 1. Stakeholder Management

#### Administrators (Administradores)
- **Controller**: `AdministradoresController`
- **Table**: `AdministradoresTable`
- **Features**:
  - Admin entity registration and profile management
  - Linked to Users via `user_id`

#### Students (Alunos)
- **Controller**: `AlunosController`
- **Table**: `AlunosTable`
- **Features**:
  - Student registration and profile management
  - Academic record tracking
  - Internship history
  - Certificate generation
  - Shift (turno) assignment

#### Interns (Estagiarios)
- **Controller**: `EstagiariosController`
- **Table**: `EstagiariosTable`
- **Features**:
  - Internship assignment tracking
  - Activity log management
  - Grade recording
  - PDF report generation (terms, evaluations, certificates)
  - CounterCache for related entities (Alunos, Supervisores, Professores, Instituicoes)

#### Professors (Professores)
- **Controller**: `ProfessoresController`
- **Table**: `ProfessoresTable`
- **Features**:
  - Student supervision assignment
  - Visit scheduling
  - Evaluation oversight
  - Status tracking and intern count caching

#### Supervisors (Supervisores)
- **Controller**: `SupervisoresController`
- **Table**: `SupervisoresTable`
- **Features**:
  - Field supervision
  - Student performance evaluation
  - Institution association

#### Institutions (Instituicoes)
- **Controller**: `InstituicoesController`
- **Table**: `InstituicoesTable`
- **Features**:
  - Institution registration
  - Agreement tracking (convenio)
  - Insurance (seguro) management
  - Area categorization

### 2. Internship Lifecycle

#### Internship Postings (Muralestagios)
- **Controller**: `MuralestagiosController`
- **Table**: `MuralestagiosTable`
- **Features**:
  - Post internship opportunities
  - Application deadline management
  - Selection criteria definition
  - Institution association

#### Application Tracking (Inscricoes)
- **Controller**: `InscricoesController`
- **Table**: `InscricoesTable`
- **Features**:
  - Online application submission
  - Application status tracking
  - Period-based filtering
  - CounterCache on Alunos (inscricao_count)

#### Visit Scheduling (Visitas)
- **Controller**: `VisitasController`
- **Table**: `VisitasTable`
- **Features**:
  - Schedule supervision visits
  - Visit report generation

### 3. Academic Administration

#### Evaluation Management (Avaliacoes)
- **Controller**: `AvaliacoesController`
- **Table**: `AvaliacoesTable`
- **Features**:
  - Supervisor evaluations
  - Student self-evaluations
  - PDF evaluation reports

#### Activity Log (Folhadeatividades)
- **Controller**: `FolhadeatividadesController`
- **Table**: `FolhadeatividadesTable`
- **Features**:
  - Daily activity logging
  - Hour calculation
  - PDF activity sheet generation

#### Internship Classes (Turmas)
- **Controller**: `TurmasController`
- **Table**: `TurmasTable`
- **Features**:
  - Class/area categorization
  - Student grouping

#### Complements (Complementos)
- **Controller**: `ComplementosController`
- **Table**: `ComplementosTable`
- **Features**:
  - Special period configuration for internships
  - Linked to Estagiarios via `complemento_id`

### 4. Questionnaire System

#### Questionnaires (Questionarios)
- **Controller**: `QuestionariosController`
- **Table**: `QuestionariosTable`
- **Features**:
  - Create and manage questionnaires
  - Support for categories and target user types
  - Active/inactive status

#### Questions (Questoes)
- **Controller**: `QuestoesController`
- **Table**: `QuestoesTable`
- **Features**:
  - Define questions with text, type, and ordering
  - Support for multiple question types
  - Options for multiple-choice questions

#### Answers (Respostas)
- **Controller**: `RespostasController`
- **Table**: `RespostasTable`
- **Features**:
  - Record intern responses to questionnaires
  - Linked to both Questionarios and Estagiarios

### 5. System Configuration

#### Settings (Configuracoes)
- **Controller**: `ConfiguracoesController`
- **Table**: `ConfiguracoesTable`
- **Features**:
  - Current period configuration (`mural_periodo_atual`)
  - System-wide settings
  - Loaded globally in `AppController::initialize()`

#### Categories (Categorias)
- **Controller**: `CategoriasController`
- **Table**: `CategoriasTable`
- **Features**:
  - User role classification

#### Areas (Areas)
- **Controller**: `AreasController`
- **Table**: `AreasTable`
- **Features**:
  - Institutional area classification
  - Used by Instituicoes via `area_id`

#### Shifts (Turnos)
- **Controller**: `TurnosController`
- **Table**: `TurnosTable`
- **Features**:
  - Student shift/time-slot management
  - Used by Alunos via `turno_id`

### 6. Document Generation

The system generates various PDF documents:

| Document | Controller Method | Template |
|----------|-------------------|----------|
| Commitment Term | `termodecompromisso()` | `termodecompromisso.php` |
| Student Evaluation | `avaliacaodiscentepdf()` | `avaliacaodiscentepdf.php` |
| Activity Sheet | `folhadeatividadespdf()` | `folhadeatividadespdf.php` |
| Certificate | `certificadoperiodo()` | `certificadoperiodo.php` |
| CRESS Spreadsheet | `planilhacress()` | `planilhacress.php` |
| Insurance Spreadsheet | `planilhaseguro()` | `planilhaseguro.php` |

---

## Database Schema

### Core Tables

| Table | Description | Key Relationships |
|-------|-------------|-------------------|
| `administradores` | Admin entity records | belongsTo Users |
| `alunos` | Student records | belongsTo Users, Turnos; hasMany Estagiarios, Inscricoes |
| `areas` | Institutional areas | hasMany Instituicoes |
| `avaliacoes` | Evaluations | belongsTo Estagiarios |
| `categorias` | User role categories | hasMany Users |
| `complementos` | Special period configs | hasMany Estagiarios |
| `configuracoes` | System settings | — |
| `estagiarios` | Internship assignments | belongsTo Alunos, Instituicoes, Professores, Supervisores, Complementos; hasMany Folhadeatividades; hasOne Avaliacoes, Respostas |
| `folhadeatividades` | Activity logs | belongsTo Estagiarios |
| `inscricoes` | Applications | belongsTo Alunos, Muralestagios |
| `instituicoes` | Partner institutions | belongsTo Areas; hasMany Estagiarios, Muralestagios |
| `muralestagio` | Internship postings | belongsTo Instituicoes, Professores |
| `professores` | Faculty | hasMany Estagiarios; belongsTo Users |
| `questionarios` | Questionnaires | hasMany Questoes |
| `questoes` | Questions | belongsTo Questionarios |
| `respostas` | Questionnaire answers | belongsTo Questionarios, Estagiarios |
| `supervisores` | Field supervisors | hasMany Estagiarios; belongsTo Users |
| `turmas` | Internship classes | — |
| `turnos` | Student shifts | hasMany Alunos |
| `users` | System users | belongsTo Categorias; hasOne Administradores, Alunos, Professores, Supervisores |
| `visitas` | Supervision visits | belongsTo Instituicoes |

### Relationship Diagram

```
Users ||--o| Administradores : has_one
Users ||--o| Alunos : has_one
Users ||--o| Professores : has_one
Users ||--o| Supervisores : has_one
Users }o--o| Categorias : belongs_to

Turnos ||--o{ Alunos : has_many
Alunos ||--o{ Estagiarios : has_many
Alunos ||--o{ Inscricoes : has_many

Areas ||--o{ Instituicoes : has_many
Instituicoes ||--o{ Estagiarios : has_many
Instituicoes ||--o{ Muralestagios : has_many
Instituicoes ||--o{ Visitas : has_many

Professores ||--o{ Estagiarios : has_many
Supervisores ||--o{ Estagiarios : has_many
Complementos ||--o{ Estagiarios : has_many

Estagiarios ||--o{ Folhadeatividades : has_many
Estagiarios ||--o| Avaliacoes : has_one
Estagiarios ||--o| Respostas : has_one

Muralestagios ||--o{ Inscricoes : has_many

Questionarios ||--o{ Questoes : has_many
Questionarios ||--o{ Respostas : has_many
```

---

## Key Features

### 1. Multi-Role Dashboard
- Role-specific navigation menus
- Personalized views based on user type
- Contextual actions and permissions via policy-based authorization

### 2. Period-Based Management
- Academic period tracking via `Configuracoes.mural_periodo_atual`
- Historical data preservation
- Period filtering across modules (defaults to current period, overridable with `?periodo=`)

### 3. PDF Document Generation
- Automated form filling via CakePdf/DomPDF
- Professional document templates
- Downloadable reports

### 4. Questionnaire System
- Create questionnaires with structured questions
- Record intern responses
- Support for multiple question types and categories

### 5. Application Workflow
1. Institution posts opportunity
2. Students apply online
3. Selection process
4. Internship assignment
5. Activity logging
6. Evaluation submission
7. Questionnaire responses
8. Certificate generation

### 6. Security Features
- Password hashing (DefaultPasswordHasher)
- CSRF protection middleware
- Policy-based role access control
- SQL injection prevention (parameterized queries)
- Host Header Injection prevention (custom `HostHeaderMiddleware`)

---

## Installation

### Requirements

- PHP 8.1 or higher
- MySQL 5.7+ / MariaDB
- Apache/Nginx with mod_rewrite
- Composer

### Steps

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd mural5
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure database**:
   - Copy `config/app_local.example.php` to `config/app_local.php`
   - Update database credentials in `config/.env`

4. **Run database migrations**:
   ```bash
   bin/cake migrations migrate
   ```

5. **Set permissions**:
   ```bash
   chmod -R 777 tmp/
   chmod -R 777 logs/
   ```

6. **Configure web server**:
   - Point document root to `webroot/`
   - Enable mod_rewrite

---

## Configuration

### Key Configuration Files

| File | Purpose |
|------|---------|
| `config/app.php` | Application settings (including CakePdf/DomPDF) |
| `config/app_local.php` | Local environment (database, email) |
| `config/.env` | Environment variables |
| `config/routes.php` | URL routing rules |
| `config/bootstrap.php` | Application bootstrap |
| `phpcs.xml` | Code style configuration (PSR12) |
| `phpunit.xml.dist` | PHPUnit configuration |

### Environment Variables

```bash
# Database
export DATABASE_URL="mysql://user:pass@localhost/mural"

# Debug mode
export DEBUG="true"

# Full base URL
export FULL_BASE_URL="https://mural.ess.ufrj.br"
```

### Middleware Stack

```
ErrorHandlerMiddleware
HostHeaderMiddleware      # Validates Host header in production; skipped in debug
AssetMiddleware
RoutingMiddleware
BodyParserMiddleware
AuthenticationMiddleware
AuthorizationMiddleware
CsrfProtectionMiddleware
```

---

## API Endpoints

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/users/login` | User login |
| POST | `/users/logout` | User logout |

### Main Resources

| Resource | Base Endpoint |
|----------|---------------|
| Administradores | `/administradores` |
| Alunos | `/alunos` |
| Areas | `/areas` |
| Avaliacoes | `/avaliacoes` |
| Complementos | `/complementos` |
| Estagiarios | `/estagiarios` |
| Folhadeatividades | `/folhadeatividades` |
| Inscricoes | `/inscricoes` |
| Instituicoes | `/instituicoes` |
| Muralestagios | `/muralestagios` |
| Questionarios | `/questionarios` |
| Questoes | `/questoes` |
| Respostas | `/respostas` |
| Turmas | `/turmas` |
| Turnos | `/turnos` |
| Visitas | `/visitas` |

### Common Actions

All controllers follow RESTful conventions:

| Action | HTTP Method | URL Pattern | Description |
|--------|-------------|-------------|-------------|
| index | GET | `/controller` | List all records |
| view | GET | `/controller/view/:id` | View single record |
| add | GET/POST | `/controller/add` | Create new record |
| edit | GET/POST | `/controller/edit/:id` | Edit record |
| delete | POST | `/controller/delete/:id` | Delete record |

---

## Development Notes

### Code Standards

- PSR12 standard (`phpcs.xml`)
- `declare(strict_types=1);` at the top of PHP files
- Use type declarations and PHP 8 native return types
- Explicit `use` statements, sorted alphabetically

### Testing

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
```

### Common Issues

1. **Pagination**: Use `setPaginated()` and `getPaginationResult()` in CakePHP 5.x
2. **Authorization**: Use policy-based checks (`$this->Authorization->authorize()`) — not inline role checks
3. **Date formatting**: Database dates are `Y-m-d`, not `d-m-Y`
4. **Table loading**: Use `$this->fetchTable('TableName')` when table isn't directly associated
5. **User linking**: `User::getOriginalData()` resolves role foreign keys dynamically — always use it for role checks

---

## License

This project is licensed under the MIT License.

---

## Contact

**Escola de Serviço Social - UFRJ**
- Website: http://www.ess.ufrj.br
- Address: Avenida Pasteur, 250 - Urca, Rio de Janeiro

---

*Last updated: September 2026*
