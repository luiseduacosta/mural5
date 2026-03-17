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
| Language | PHP 8.x |
| Database | MySQL |
| Frontend | Bootstrap 5, jQuery |
| PDF Generation | CakePdf (DomPDF) |
| Authentication | CakePHP Authentication Plugin |

### Directory Structure

```
mural5/
├── bin/                    # CakePHP console scripts
├── config/                 # Configuration files
│   ├── app.php            # Main application config
│   ├── app_local.php      # Local environment config
│   ├── routes.php         # URL routing
│   └── schema/            # Database schemas
├── src/                   # Application source code
│   ├── Controller/        # 22 Controllers
│   ├── Model/
│   │   ├── Entity/        # Data entities
│   │   └── Table/         # 20 Table models
│   └── View/              # View classes
├── templates/             # View templates (25+ directories)
├── webroot/               # Public assets
│   ├── css/
│   ├── js/
│   └── img/
└── plugins/               # CakePHP plugins
```

---

## User Roles & Authorization

The system implements **Role-Based Access Control (RBAC)** with four distinct user categories:

| Role | ID | Description | Key Permissions |
|------|-----|-------------|-----------------|
| **Administrator** | 1 | System administrators | Full access to all modules |
| **Student** | 2 | Internship students | View opportunities, submit applications, track progress |
| **Professor** | 3 | Faculty supervisors | Evaluate students, manage visits |
| **Supervisor** | 4 | Field supervisors | Evaluate intern performance |

### Authorization Methods

The `User` entity provides convenient methods for role checking:

```php
$user->isAdmin()      // categoria == 1
$user->isAluno()      // categoria == 2  
$user->isProfessor()  // categoria == 3
$user->isSupervisor() // categoria == 4
```

### Authorization Pattern

Controllers use a standardized authorization pattern:

```php
// Allow both admin and students
if (!$this->user->isAdmin() && !$this->user->isStudent()) {
    // Block access
}

// Student ownership verification
if ($this->user->isStudent()) {
    $estagiario = $this->fetchTable('Estagiarios')->find()
        ->where(['id' => $id, 'aluno_id' => $this->user->aluno_id])
        ->first();
    if (!$estagiario) {
        // Unauthorized - not their record
    }
}
```

---

## Core Modules

### 1. Stakeholder Management

#### Students (Alunos)
- **Controller**: `AlunosController`
- **Table**: `AlunosTable`
- **Features**:
  - Student registration and profile management
  - Academic record tracking
  - Internship history
  - Certificate generation

#### Interns (Estagiarios)
- **Controller**: `EstagiariosController`
- **Table**: `EstagiariosTable`
- **Features**:
  - Internship assignment tracking
  - Activity log management
  - Grade recording
  - PDF report generation (terms, evaluations, certificates)

#### Professors (Professores)
- **Controller**: `ProfessoresController`
- **Table**: `ProfessoresTable`
- **Features**:
  - Student supervision assignment
  - Visit scheduling
  - Evaluation oversight

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
- **Controller**: `MuralinscricoesController`
- **Table**: `MuralinscricoesTable`
- **Features**:
  - Online application submission
  - Application status tracking
  - Period-based filtering

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

#### Internship Classes (Turmaestagios)
- **Controller**: `TurmaestagiosController`
- **Table**: `TurmaestagiosTable`
- **Features**:
  - Class/area categorization
  - Student grouping
  - Related institutions and postings

### 4. Document Generation

The system generates various PDF documents:

| Document | Controller Method | Template |
|----------|-------------------|----------|
| Commitment Term | `termodecompromisso()` | `termodecompromisso.php` |
| Student Evaluation | `avaliacaodiscentepdf()` | `avaliacaodiscentepdf.php` |
| Activity Sheet | `folhadeatividadespdf()` | `folhadeatividadespdf.php` |
| Certificate | `certificadoperiodo()` | `certificadoperiodo.php` |
| CRESS Spreadsheet | `planilhacress()` | `planilhacress.php` |
| Insurance Spreadsheet | `planilhaseguro()` | `planilhaseguro.php` |

### 5. System Configuration

#### Settings (Configuracoes)
- **Controller**: `ConfiguracoesController`
- **Table**: `ConfiguracoesTable`
- **Features**:
  - Current period configuration
  - System-wide settings

#### Categories (Categorias)
- **Controller**: `CategoriasController`
- **Table**: `CategoriasTable`
- **Features**:
  - User role management

#### Areas (Areainstituicoes)
- **Controller**: `AreainstituicoesController`
- **Table**: `AreainstituicoesTable`
- **Features**:
  - Institutional area classification

---

## Database Schema

### Core Tables

| Table | Description | Key Relationships |
|-------|-------------|-------------------|
| `alunos` | Student records | hasMany Estagiarios |
| `estagiarios` | Internship assignments | belongsTo Alunos, Instituicoes, Professores, Supervisores, Turmaestagios |
| `instituicoes` | Partner institutions | hasMany Estagiarios, Muralestagios |
| `muralestagio` | Internship postings | belongsTo Instituicoes, Professores |
| `mural_inscricoes` | Applications | belongsTo Alunos, Muralestagios |
| `avaliacoes` | Evaluations | belongsTo Estagiarios |
| `folhadeatividades` | Activity logs | belongsTo Estagiarios |
| `turma_estagios` | Internship classes | hasMany Estagiarios |
| `professores` | Faculty | hasMany Estagiarios |
| `supervisores` | Field supervisors | hasMany Estagiarios, belongsToMany Instituicoes |
| `visitas` | Supervision visits | belongsTo Instituicoes |
| `users` | System users | belongsTo Alunos, Professores, Supervisores |

### Relationship Diagram

```
Alunos ||--o{ Estagiarios : has_many
Instituicoes ||--o{ Estagiarios : has_many
Instituicoes ||--o{ Muralestagios : has_many
Professores ||--o{ Estagiarios : has_many
Supervisores ||--o{ Estagiarios : has_many
Turmaestagios ||--o{ Estagiarios : has_many
Estagiarios ||--o{ Avaliacoes : has_many
Estagiarios ||--o{ Folhadeatividades : has_many
Alunos ||--o{ Muralinscricoes : has_many
Muralestagios ||--o{ Muralinscricoes : has_many
Instituicoes ||--o{ Visitas : has_many
```

---

## Key Features

### 1. Multi-Role Dashboard
- Role-specific navigation menus
- Personalized views based on user type
- Contextual actions and permissions

### 2. Period-Based Management
- Academic period tracking
- Historical data preservation
- Period filtering across modules

### 3. PDF Document Generation
- Automated form filling
- Professional document templates
- Downloadable reports

### 4. Application Workflow
1. Institution posts opportunity
2. Students apply online
3. Selection process
4. Internship assignment
5. Activity logging
6. Evaluation submission
7. Certificate generation

### 5. Security Features
- Password hashing (DefaultPasswordHasher)
- CSRF protection
- Role-based access control
- SQL injection prevention (parameterized queries)

---

## Installation

### Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
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
   - Update database credentials

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
| `config/app.php` | Application settings |
| `config/app_local.php` | Local environment (database, email) |
| `config/routes.php` | URL routing rules |
| `config/bootstrap.php` | Application bootstrap |

### Environment Variables

```bash
# Database
export DATABASE_URL="mysql://user:pass@localhost/mural"

# Debug mode
export DEBUG="true"

# Full base URL
export FULL_BASE_URL="https://mural.ess.ufrj.br"
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
| Alunos | `/alunos` |
| Estagiarios | `/estagiarios` |
| Instituicoes | `/instituicoes` |
| Muralestagios | `/muralestagios` |
| Avaliacoes | `/avaliacoes` |
| Folhadeatividades | `/folhadeatividades` |

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

- Follow CakePHP coding standards
- Use type declarations (strict_types=1)
- Document all methods with PHPDoc
- Use meaningful variable names

### Testing

```bash
# Run PHPUnit tests
vendor/bin/phpunit

# Run code sniffer
vendor/bin/phpcs --standard=phpcs.xml src/
```

### Common Issues

1. **Pagination**: Use `setPaginated()` and `getPaginationResult()` in CakePHP 5.x
2. **Authorization**: Use `&&` for role checks (not `||`)
3. **Date formatting**: Database dates are `Y-m-d`, not `d-m-Y`
4. **Table loading**: Use `$this->fetchTable('TableName')` when table isn't directly associated

---

## License

This project is licensed under the MIT License.

---

## Contact

**Escola de Serviço Social - UFRJ**
- Website: http://www.ess.ufrj.br
- Address: Avenida Pasteur, 250 - Urca, Rio de Janeiro

---

*Last updated: February 2026*
