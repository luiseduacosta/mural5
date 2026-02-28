-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/02/2026 às 05:52
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mural_ess`
--
CREATE DATABASE IF NOT EXISTS `mural_ess` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mural_ess`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `administradores`
--

CREATE TABLE IF NOT EXISTS `administradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Administradores do sistema';

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `nomesocial` varchar(50) DEFAULT NULL,
  `ingresso` char(6) DEFAULT NULL,
  `turno` varchar(7) DEFAULT NULL,
  `registro` int(9) NOT NULL DEFAULT 0,
  `codigo_telefone` tinyint(2) NOT NULL DEFAULT 21,
  `telefone` varchar(15) DEFAULT NULL,
  `codigo_celular` tinyint(2) NOT NULL DEFAULT 21,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `identidade` varchar(15) DEFAULT NULL,
  `orgao` varchar(30) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `observacoes` varchar(250) DEFAULT NULL,
  `estagiario_count` int(10) DEFAULT NULL,
  `inscricao_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registro` (`registro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Alunos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `area_instituicoes`
--

CREATE TABLE IF NOT EXISTS `area_instituicoes` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `area` varchar(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Áreas de instituições de estágio';

-- --------------------------------------------------------

--
-- Estrutura para tabela `auth_users`
--

CREATE TABLE IF NOT EXISTS `auth_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `identificacao` varchar(50) DEFAULT NULL COMMENT 'Either DRE, Siape ou CRESS',
  `role` enum('admin','supervisor','docente','aluno') DEFAULT 'aluno',
  `entidade_id` int(11) DEFAULT NULL COMMENT 'Id of the aluno, docente or supervisor table',
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Usuários do sistema: versão javascript';

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estagiario_id` int(11) NOT NULL,
  `avaliacao1` char(1) NOT NULL,
  `avaliacao2` char(1) NOT NULL,
  `avaliacao3` char(1) NOT NULL,
  `avaliacao4` char(1) NOT NULL,
  `avaliacao5` char(1) NOT NULL,
  `avaliacao6` char(1) NOT NULL,
  `avaliacao7` char(1) NOT NULL,
  `avaliacao8` char(1) NOT NULL,
  `avaliacao9` char(1) NOT NULL,
  `avaliacao9_1` varchar(255) DEFAULT NULL,
  `avaliacao10` char(1) NOT NULL,
  `avaliacao10_1` varchar(255) DEFAULT NULL,
  `avaliacao11` char(1) NOT NULL,
  `avaliacao11_1` varchar(255) DEFAULT NULL,
  `avaliacao12` char(1) NOT NULL,
  `avaliacao12_1` varchar(255) DEFAULT NULL,
  `avaliacao13` char(1) NOT NULL,
  `avaliacao13_1` varchar(255) DEFAULT NULL,
  `avaliacao14` varchar(255) NOT NULL,
  `observacoes` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Avaliação dos estagiários. Obsoleta. Substituída por respostas de avaliação';

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Categorias dos usuários: administrador, professor, supervisor e aluno';

-- --------------------------------------------------------

--
-- Estrutura para tabela `complementos`
--

CREATE TABLE IF NOT EXISTS `complementos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo_especial` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabela para o período especial da pandemia 2020';

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE IF NOT EXISTS `configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mural_periodo_atual` char(6) NOT NULL,
  `curso_turma_atual` smallint(2) NOT NULL,
  `curso_abertura_inscricoes` date NOT NULL,
  `curso_encerramento_inscricoes` date NOT NULL,
  `termo_compromisso_periodo` char(6) NOT NULL,
  `termo_compromisso_inicio` date NOT NULL,
  `termo_compromisso_final` date NOT NULL,
  `periodo_calendario_academico` char(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Configurações do sistema';

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagiarios`
--

CREATE TABLE IF NOT EXISTS `estagiarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_id` int(11) NOT NULL,
  `alunoestagiario_id` smallint(6) NOT NULL,
  `registro` int(11) NOT NULL,
  `turno` char(1) NOT NULL,
  `nivel` char(1) NOT NULL,
  `tc` smallint(6) NOT NULL,
  `tc_solicitacao` date NOT NULL,
  `instituicao_id` smallint(6) NOT NULL,
  `supervisor_id` smallint(6) NOT NULL,
  `professor_id` smallint(6) NOT NULL,
  `periodo` varchar(6) NOT NULL,
  `turmaestagio_id` tinyint(4) NOT NULL,
  `nota` decimal(4,2) NOT NULL,
  `ch` smallint(6) NOT NULL,
  `observacoes` varchar(255) NOT NULL,
  `complemento_id` int(11) NOT NULL,
  `ajuste2020` char(1) NOT NULL,
  `benetransporte` tinyint(1) NOT NULL,
  `benealimentacao` tinyint(1) NOT NULL,
  `benebolsa` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Estagiários';

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagio`
--

CREATE TABLE IF NOT EXISTS `estagio` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `areainstituicoes_id` smallint(3) DEFAULT NULL,
  `area` smallint(3) DEFAULT 0,
  `natureza` varchar(50) DEFAULT NULL,
  `instituicao` varchar(120) NOT NULL DEFAULT '',
  `cnpj` char(18) NOT NULL,
  `email` varchar(90) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `endereco` varchar(105) NOT NULL DEFAULT '',
  `bairro` varchar(30) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `cep` char(9) NOT NULL DEFAULT '',
  `telefone` varchar(50) NOT NULL DEFAULT '',
  `fax` varchar(20) NOT NULL DEFAULT '',
  `beneficio` varchar(50) DEFAULT NULL,
  `fim_de_semana` char(1) DEFAULT '0',
  `localInscricao` set('0','1') NOT NULL DEFAULT '0',
  `convenio` int(4) DEFAULT NULL,
  `expira` date DEFAULT NULL,
  `seguro` char(1) DEFAULT NULL,
  `avaliacao` set('1','2','3','4','5') NOT NULL DEFAULT '3',
  `observacoes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Instituições de estágio';

-- --------------------------------------------------------

--
-- Estrutura para tabela `folhadeatividades`
--

CREATE TABLE IF NOT EXISTS `folhadeatividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estagiario_id` int(11) NOT NULL,
  `dia` date NOT NULL,
  `inicio` time NOT NULL,
  `final` time NOT NULL,
  `horario` time GENERATED ALWAYS AS (timediff(`final`,`inicio`)) STORED,
  `atividade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Formulário de atividades realizadas pelo estagiário';

-- --------------------------------------------------------

--
-- Estrutura para tabela `inst_super`
--

CREATE TABLE IF NOT EXISTS `inst_super` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `instituicao_id` smallint(4) NOT NULL,
  `supervisor_id` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Instituições de estágio e supervisores';

-- --------------------------------------------------------

--
-- Estrutura para tabela `mural_estagio`
--

CREATE TABLE IF NOT EXISTS `mural_estagio` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(4) NOT NULL,
  `instituicao` varchar(100) NOT NULL,
  `convenio` char(1) NOT NULL,
  `vagas` tinyint(3) NOT NULL,
  `beneficios` varchar(70) NOT NULL,
  `final_de_semana` char(1) NOT NULL,
  `cargaHoraria` tinyint(2) NOT NULL,
  `requisitos` varchar(455) NOT NULL,
  `turmaestagio_id` tinyint(2) NOT NULL,
  `horario` char(1) NOT NULL,
  `professor_id` tinyint(3) NOT NULL,
  `dataSelecao` date NOT NULL,
  `dataInscricao` date NOT NULL,
  `horarioSelecao` varchar(5) NOT NULL,
  `localSelecao` varchar(70) NOT NULL,
  `formaSelecao` char(1) NOT NULL,
  `contato` varchar(70) NOT NULL,
  `outras` text NOT NULL,
  `periodo` varchar(6) NOT NULL,
  `datafax` date NOT NULL,
  `localInscricao` set('0','1') NOT NULL,
  `email` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Mural de ofertas de estágios.';

-- --------------------------------------------------------

--
-- Estrutura para tabela `mural_inscricao`
--

CREATE TABLE IF NOT EXISTS `mural_inscricao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registro` int(9) NOT NULL,
  `muralestagio_id` smallint(3) NOT NULL,
  `data` date NOT NULL,
  `periodo` char(6) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `alunonovo_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Inscrições de alunos para seleção de estágios';

-- --------------------------------------------------------

--
-- Estrutura para tabela `professores`
--

CREATE TABLE IF NOT EXISTS `professores` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` char(14) NOT NULL,
  `siape` mediumint(10) NOT NULL,
  `cress` int(10) NOT NULL,
  `regiao` int(3) NOT NULL,
  `datanascimento` date NOT NULL,
  `localnascimento` varchar(30) NOT NULL,
  `sexo` enum('2','1') NOT NULL,
  `ddd_telefone` char(2) NOT NULL DEFAULT '21',
  `telefone` varchar(15) NOT NULL,
  `ddd_celular` char(2) NOT NULL DEFAULT '21',
  `celular` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `homepage` varchar(120) NOT NULL,
  `redesocial` varchar(50) NOT NULL,
  `curriculolattes` varchar(50) NOT NULL,
  `atualizacaolattes` date NOT NULL,
  `curriculosigma` varchar(7) NOT NULL,
  `pesquisadordgp` varchar(20) NOT NULL,
  `formacaoprofissional` varchar(30) NOT NULL,
  `universidadedegraduacao` varchar(50) NOT NULL,
  `anoformacao` mediumint(4) NOT NULL,
  `mestradoarea` varchar(40) NOT NULL,
  `mestradouniversidade` varchar(50) NOT NULL,
  `mestradoanoconclusao` mediumint(4) NOT NULL,
  `doutoradoarea` varchar(40) NOT NULL,
  `doutoradouniversidade` varchar(50) NOT NULL,
  `doutoradoanoconclusao` mediumint(4) NOT NULL,
  `dataingresso` date NOT NULL,
  `formaingresso` varchar(100) NOT NULL,
  `tipocargo` varchar(10) NOT NULL,
  `categoria` varchar(10) NOT NULL,
  `regimetrabalho` varchar(5) NOT NULL,
  `departamento` varchar(30) NOT NULL,
  `dataegresso` date NOT NULL,
  `motivoegresso` varchar(100) NOT NULL,
  `observacoes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Professores';

-- --------------------------------------------------------

--
-- Estrutura para tabela `questionarios`
--

CREATE TABLE IF NOT EXISTS `questionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'O título do questionário',
  `description` text NOT NULL COMMENT 'Uma descrição mais detalhada do questionário',
  `created` datetime NOT NULL COMMENT 'Timestamp quando o questionário foi criado',
  `modified` datetime NOT NULL COMMENT 'Timestamp quando o questionário foi modificado pela última vez',
  `is_active` tinyint(1) NOT NULL COMMENT 'Se o questionário está ativo e disponível para uso',
  `category` varchar(100) NOT NULL COMMENT 'Categoria opcional para agrupar questionários (por exemplo, "Feedback de Aluno", "Avaliação de Curso")',
  `target_user_type` varchar(50) NOT NULL COMMENT 'Tipo de usuário alvo para o questionário',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Questionários';

-- --------------------------------------------------------

--
-- Estrutura para tabela `questoes`
--

CREATE TABLE IF NOT EXISTS `questoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionario_id` int(11) NOT NULL,
  `text` text NOT NULL COMMENT 'O texto da questão',
  `type` varchar(50) NOT NULL COMMENT 'O tipo de questão (text, textarea, select, scale, boolean)',
  `options` text NOT NULL COMMENT 'JSON encoded options for select/scale questions',
  `created` datetime NOT NULL COMMENT 'Timestamp when the question was created',
  `modified` datetime NOT NULL COMMENT 'Timestamp when the question was last modified',
  `ordem` int(11) NOT NULL COMMENT 'The order in which the question should appear in the questionnaire',
  PRIMARY KEY (`id`),
  KEY `questionnaire_id` (`questionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Questões de avaliação';

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas`
--

CREATE TABLE IF NOT EXISTS `respostas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionario_id` int(11) NOT NULL COMMENT 'The questionnaire id',
  `estagiario_id` int(11) NOT NULL COMMENT 'ID of the user who answered the question',
  `response` text NOT NULL COMMENT 'The answer to the question',
  `created` datetime NOT NULL COMMENT 'Timestamp when the response was created',
  `modified` datetime NOT NULL COMMENT 'Timestamp when the response was last modified',
  PRIMARY KEY (`id`),
  KEY `estagiarios_id` (`estagiario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Respostas às perguntas de avaliação. Substitui a tabela avaliacao';

-- --------------------------------------------------------

--
-- Estrutura para tabela `supervisores`
--

CREATE TABLE IF NOT EXISTS `supervisores` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `municipio` varchar(30) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `codigo_tel` char(2) NOT NULL DEFAULT '21',
  `telefone` varchar(15) NOT NULL,
  `codigo_cel` char(2) NOT NULL DEFAULT '21',
  `celular` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `escola` varchar(70) NOT NULL,
  `ano_formatura` varchar(4) NOT NULL,
  `cress` int(6) NOT NULL,
  `regiao` tinyint(2) NOT NULL DEFAULT 7,
  `outros_estudos` varchar(100) NOT NULL,
  `area_curso` varchar(40) NOT NULL,
  `ano_curso` varchar(4) NOT NULL,
  `cargo` varchar(25) NOT NULL,
  `num_inscricao` int(3) NOT NULL,
  `curso_turma` char(1) NOT NULL,
  `observacoes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Supervisores de estagiários';

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma_estagios`
--

CREATE TABLE IF NOT EXISTS `turma_estagios` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `area` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Turmas de estagiários';

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` char(50) NOT NULL,
  `password` char(80) NOT NULL,
  `categoria` enum('1','2','3','4') NOT NULL DEFAULT '2',
  `numero` int(9) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estudante_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'Usuários: administradores, professores, supervisores e alunos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `visita`
--

CREATE TABLE IF NOT EXISTS `visita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `instituicao_id` int(11) NOT NULL COMMENT 'id_estagio',
  `data` date NOT NULL,
  `motivo` varchar(256) NOT NULL,
  `responsavel` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `avaliacao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT 'Visitas de avaliação as instituições de estágio';

--
-- Restrições para tabelas `questoes`
--
ALTER TABLE `questoes`
  ADD CONSTRAINT `questoes_ibfk_1` FOREIGN KEY (`questionario_id`) REFERENCES `questionarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
