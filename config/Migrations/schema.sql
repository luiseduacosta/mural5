-- =====================================================
-- Mural de Estágios - Schema Migration
-- Database: mural5
-- Charset: utf8mb4
-- =====================================================
-- Usage:
--   mysql -u root -p mural5 < config/Migrations/schema.sql
--   mysql -u root -p mural5_test < config/Migrations/schema.sql
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- =====================================================
-- Table: categorias
-- =====================================================
CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `categoria` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Administrador'),
(2, 'Aluno'),
(3, 'Professor'),
(4, 'Supervisor');

-- =====================================================
-- Table: users
-- =====================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(128) NOT NULL,
    `email` CHAR(50) NOT NULL,
    `password` CHAR(80) NOT NULL,
    `categoria` ENUM('1','2','3','4') NOT NULL DEFAULT '2',
    `role` ENUM('admin','supervisor','docente','aluno') DEFAULT 'aluno',
    `identificacao` INT(9) DEFAULT NULL,
    `entidade_id` INT(11) DEFAULT NULL,
    `aluno_id` INT(11) DEFAULT NULL,
    `supervisor_id` INT(11) DEFAULT NULL,
    `professor_id` INT(11) DEFAULT NULL,
    `ativo` TINYINT(1) NOT NULL DEFAULT 1,
    `criado_em` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
    `atualizado_em` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: administradores
-- =====================================================
CREATE TABLE IF NOT EXISTS `administradores` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(128) NOT NULL,
    `user_id` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: areas
-- =====================================================
CREATE TABLE IF NOT EXISTS `areas` (
    `id` SMALLINT(3) NOT NULL AUTO_INCREMENT,
    `area` VARCHAR(90) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `areas` (`area`) VALUES ('Saúde'), ('Educação'), ('Assistência Social');

-- =====================================================
-- Table: instituicoes
-- =====================================================
CREATE TABLE IF NOT EXISTS `instituicoes` (
    `id` INT(4) NOT NULL AUTO_INCREMENT,
    `area_id` SMALLINT(3) DEFAULT NULL,
    `natureza` VARCHAR(50) DEFAULT NULL,
    `instituicao` VARCHAR(120) NOT NULL DEFAULT '',
    `cnpj` CHAR(18) DEFAULT NULL,
    `email` VARCHAR(90) DEFAULT NULL,
    `url` VARCHAR(100) DEFAULT NULL,
    `endereco` VARCHAR(105) NOT NULL DEFAULT '',
    `bairro` VARCHAR(30) DEFAULT NULL,
    `municipio` VARCHAR(30) DEFAULT NULL,
    `cep` CHAR(9) NOT NULL DEFAULT '',
    `telefone` VARCHAR(50) NOT NULL DEFAULT '',
    `beneficio` VARCHAR(50) DEFAULT NULL,
    `fim_de_semana` CHAR(1) DEFAULT '0',
    `convenio` INT(4) DEFAULT NULL,
    `expira` DATE DEFAULT NULL,
    `seguro` CHAR(1) DEFAULT NULL,
    `observacoes` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: supervisores
-- =====================================================
CREATE TABLE IF NOT EXISTS `supervisores` (
    `id` INT(4) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(70) NOT NULL,
    `cpf` VARCHAR(14) DEFAULT NULL,
    `endereco` VARCHAR(100) DEFAULT NULL,
    `bairro` VARCHAR(30) DEFAULT NULL,
    `municipio` VARCHAR(30) DEFAULT NULL,
    `cep` VARCHAR(9) DEFAULT NULL,
    `codigo_telefone` CHAR(2) DEFAULT NULL DEFAULT '21',
    `telefone` VARCHAR(15) DEFAULT NULL,
    `codigo_celular` CHAR(2) DEFAULT NULL DEFAULT '21',
    `celular` VARCHAR(15) DEFAULT NULL,
    `email` VARCHAR(50) DEFAULT NULL,
    `escola` VARCHAR(70) DEFAULT NULL,
    `ano_formatura` VARCHAR(4) DEFAULT NULL,
    `cress` INT(6) NOT NULL,
    `regiao` TINYINT(2) NOT NULL DEFAULT 7,
    `cargo` VARCHAR(25) DEFAULT NULL,
    `observacoes` TEXT DEFAULT NULL,
    `user_id` INT(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: inst_super (junction table)
-- =====================================================
CREATE TABLE IF NOT EXISTS `inst_super` (
    `id` INT(4) NOT NULL AUTO_INCREMENT,
    `instituicao_id` SMALLINT(4) NOT NULL,
    `supervisor_id` SMALLINT(4) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: professores
-- =====================================================
CREATE TABLE IF NOT EXISTS `professores` (
    `id` INT(3) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(50) NOT NULL,
    `cpf` CHAR(14) DEFAULT NULL,
    `siape` MEDIUMINT(10) NOT NULL,
    `cress` INT(10) DEFAULT NULL,
    `regiao` INT(3) DEFAULT NULL,
    `codigo_telefone` CHAR(2) NOT NULL DEFAULT '21',
    `telefone` VARCHAR(15) DEFAULT NULL,
    `codigo_celular` CHAR(2) NOT NULL DEFAULT '21',
    `celular` VARCHAR(15) DEFAULT NULL,
    `email` VARCHAR(40) DEFAULT NULL,
    `curriculolattes` VARCHAR(50) DEFAULT NULL,
    `atualizacaolattes` DATE DEFAULT NULL,
    `dataingresso` DATE DEFAULT NULL,
    `departamento` VARCHAR(30) DEFAULT NULL,
    `dataegresso` DATE DEFAULT NULL,
    `motivoegresso` VARCHAR(100) DEFAULT NULL,
    `observacoes` TEXT DEFAULT NULL,
    `user_id` INT(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: turnos
-- =====================================================
CREATE TABLE IF NOT EXISTS `turnos` (
    `id` SMALLINT(3) NOT NULL AUTO_INCREMENT,
    `turno` VARCHAR(70) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `turnos` (`turno`) VALUES ('diurno'), ('noturno'), ('integral'), ('outro');

-- =====================================================
-- Table: alunos
-- =====================================================
CREATE TABLE IF NOT EXISTS `alunos` (
    `id` INT(4) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(50) NOT NULL,
    `nomesocial` VARCHAR(50) DEFAULT NULL,
    `ingresso` CHAR(6) NOT NULL,
    `turno_id` VARCHAR(7) DEFAULT NULL,
    `registro` INT(9) NOT NULL DEFAULT 0,
    `codigo_telefone` TINYINT(2) NOT NULL DEFAULT 21,
    `telefone` VARCHAR(15) DEFAULT NULL,
    `codigo_celular` TINYINT(2) NOT NULL DEFAULT 21,
    `celular` VARCHAR(15) DEFAULT NULL,
    `email` VARCHAR(50) DEFAULT NULL,
    `cpf` VARCHAR(14) NOT NULL,
    `identidade` VARCHAR(15) DEFAULT NULL,
    `orgao` VARCHAR(30) DEFAULT NULL,
    `nascimento` DATE NOT NULL,
    `endereco` VARCHAR(50) DEFAULT NULL,
    `cep` VARCHAR(9) DEFAULT NULL,
    `municipio` VARCHAR(30) DEFAULT NULL,
    `bairro` VARCHAR(30) DEFAULT NULL,
    `observacoes` VARCHAR(250) DEFAULT NULL,
    `user_id` INT(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `registro` (`registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: complementos
-- =====================================================
CREATE TABLE IF NOT EXISTS `complementos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `periodo_especial` VARCHAR(10) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `complementos` (`periodo_especial`) VALUES ('2020-2');

-- =====================================================
-- Table: estagiarios
-- =====================================================
CREATE TABLE IF NOT EXISTS `estagiarios` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `aluno_id` INT(11) NOT NULL,
    `registro` INT(11) NOT NULL,
    `nivel` CHAR(1) NOT NULL,
    `tc` SMALLINT(6) DEFAULT NULL,
    `tc_solicitacao` DATE DEFAULT NULL,
    `instituicao_id` SMALLINT(6) NOT NULL,
    `supervisor_id` SMALLINT(6) DEFAULT NULL,
    `professor_id` SMALLINT(6) DEFAULT NULL,
    `periodo` VARCHAR(6) NOT NULL,
    `nota` DECIMAL(4,2) DEFAULT NULL,
    `ch` SMALLINT(6) DEFAULT NULL,
    `observacoes` VARCHAR(255) DEFAULT NULL,
    `complemento_id` INT(11) NOT NULL,
    `ajuste2020` CHAR(1) NOT NULL DEFAULT '1',
    `benetransporte` TINYINT(1) DEFAULT NULL,
    `benealimentacao` TINYINT(1) DEFAULT NULL,
    `benebolsa` VARCHAR(5) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: folhadeatividades
-- =====================================================
CREATE TABLE IF NOT EXISTS `folhadeatividades` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `estagiario_id` INT(11) NOT NULL,
    `dia` DATE NOT NULL,
    `inicio` TIME NOT NULL,
    `final` TIME NOT NULL,
    `horario` TIME GENERATED ALWAYS AS (timediff(`final`,`inicio`)) STORED,
    `atividade` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: mural_estagios
-- =====================================================
CREATE TABLE IF NOT EXISTS `mural_estagios` (
    `id` INT(3) NOT NULL AUTO_INCREMENT,
    `instituicao_id` INT(4) NOT NULL,
    `instituicao` VARCHAR(100) NOT NULL,
    `convenio` CHAR(1) NOT NULL,
    `vagas` TINYINT(3) NOT NULL,
    `beneficios` VARCHAR(70) DEFAULT NULL,
    `final_de_semana` CHAR(1) NOT NULL,
    `carga_horaria` TINYINT(2) DEFAULT NULL,
    `requisitos` VARCHAR(455) DEFAULT NULL,
    `horario` CHAR(1) DEFAULT NULL,
    `data_selecao` DATE DEFAULT NULL,
    `data_inscricao` DATE DEFAULT NULL,
    `horario_selecao` VARCHAR(5) DEFAULT NULL,
    `local_selecao` VARCHAR(70) DEFAULT NULL,
    `forma_selecao` CHAR(1) DEFAULT NULL,
    `contato` VARCHAR(70) DEFAULT NULL,
    `outras` TEXT DEFAULT NULL,
    `periodo` VARCHAR(6) DEFAULT NULL,
    `local_inscricao` SET('0','1') NOT NULL DEFAULT '0',
    `email` VARCHAR(70) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: inscricoes
-- =====================================================
CREATE TABLE IF NOT EXISTS `inscricoes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `registro` INT(9) NOT NULL,
    `aluno_id` INT(11) NOT NULL,
    `muralestagio_id` SMALLINT(3) NOT NULL,
    `periodo` CHAR(6) NOT NULL,
    `data` DATE NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: avaliacoes (deprecated)
-- =====================================================
CREATE TABLE IF NOT EXISTS `avaliacoes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `estagiario_id` INT(11) NOT NULL,
    `avaliacao1` CHAR(1) NOT NULL,
    `avaliacao2` CHAR(1) NOT NULL,
    `avaliacao3` CHAR(1) NOT NULL,
    `avaliacao4` CHAR(1) NOT NULL,
    `avaliacao5` CHAR(1) NOT NULL,
    `avaliacao6` CHAR(1) NOT NULL,
    `avaliacao7` CHAR(1) NOT NULL,
    `avaliacao8` CHAR(1) NOT NULL,
    `avaliacao9` CHAR(1) NOT NULL,
    `avaliacao9_1` VARCHAR(255) DEFAULT NULL,
    `avaliacao10` CHAR(1) NOT NULL,
    `avaliacao10_1` VARCHAR(255) DEFAULT NULL,
    `avaliacao11` CHAR(1) NOT NULL,
    `avaliacao11_1` VARCHAR(255) DEFAULT NULL,
    `avaliacao12` CHAR(1) NOT NULL,
    `avaliacao12_1` VARCHAR(255) DEFAULT NULL,
    `avaliacao13` CHAR(1) NOT NULL,
    `avaliacao13_1` VARCHAR(255) DEFAULT NULL,
    `avaliacao14` VARCHAR(255) NOT NULL,
    `observacoes` VARCHAR(255) NOT NULL,
    `criado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `atualizado_em` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: questionarios
-- =====================================================
CREATE TABLE IF NOT EXISTS `questionarios` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    `is_active` TINYINT(1) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `target_user_type` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: questoes
-- =====================================================
CREATE TABLE IF NOT EXISTS `questoes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `questionario_id` INT(11) NOT NULL,
    `text` TEXT NOT NULL,
    `type` VARCHAR(50) NOT NULL,
    `options` TEXT NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    `ordem` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `questionario_id` (`questionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: respostas
-- =====================================================
CREATE TABLE IF NOT EXISTS `respostas` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `questionario_id` INT(11) NOT NULL,
    `estagiario_id` INT(11) NOT NULL,
    `response` TEXT NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    KEY `estagiarios_id` (`estagiario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: turmas
-- =====================================================
CREATE TABLE IF NOT EXISTS `turmas` (
    `id` SMALLINT(3) NOT NULL AUTO_INCREMENT,
    `turma` VARCHAR(70) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: configuracoes
-- =====================================================
CREATE TABLE IF NOT EXISTS `configuracoes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `instituicao` VARCHAR(120) NOT NULL DEFAULT 'ESS/UFRJ',
    `mural_periodo_atual` CHAR(6) NOT NULL,
    `curso_turma_atual` SMALLINT(2) DEFAULT NULL,
    `curso_abertura_inscricoes` DATE DEFAULT NULL,
    `curso_encerramento_inscricoes` DATE DEFAULT NULL,
    `termo_compromisso_periodo` CHAR(6) NOT NULL,
    `termo_compromisso_inicio` DATE NOT NULL,
    `termo_compromisso_final` DATE NOT NULL,
    `periodo_calendario_academico` CHAR(6) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: visitas
-- =====================================================
CREATE TABLE IF NOT EXISTS `visitas` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `instituicao_id` INT(11) NOT NULL,
    `data` DATE NOT NULL,
    `motivo` VARCHAR(256) NOT NULL,
    `responsavel` VARCHAR(50) NOT NULL,
    `descricao` TEXT NOT NULL,
    `avaliacao` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Foreign Keys
-- =====================================================
ALTER TABLE `questoes` ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`questionario_id`) REFERENCES `questionarios` (`id`) ON DELETE CASCADE;

-- =====================================================
-- Seed Data
-- =====================================================
INSERT INTO `configuracoes` (`id`, `instituicao`, `mural_periodo_atual`, `curso_turma_atual`, `termo_compromisso_periodo`, `termo_compromisso_inicio`, `termo_compromisso_final`, `periodo_calendario_academico`) VALUES
(1, 'ESS/UFRJ', '2025-1', 1, '2025-1', '2025-03-01', '2025-07-31', '2025-1');

COMMIT;