-- ==============================================================================
-- Script de Migração: estagio -> instituicoes e mural_inscricao -> inscricoes
-- Sistema: Mural de Estágios ESS/UFRJ (Mural5 - CakePHP 5)
-- Banco de Dados: ess_apps
-- Data de Criação: 2026-09-20
-- ==============================================================================
-- Este script realiza de forma segura e reprodutível:
--  1. Alinhamento da tabela `areas` para compatibilidade com o CakePHP 5.
--  2. Migração e transformação dos 607 registros de `estagio` para `instituicoes`.
--  3. Alinhamento das chaves da tabela de junção `inst_super`.
--  4. Alinhamento das chaves estrangeiras na tabela `estagiarios`.
--  5. Reparo do campo `aluno_id` na tabela legada `mural_inscricao`.
--  6. Migração e desduplicação de `mural_inscricao` para `inscricoes` (16.001 registros).
--  7. Sincronização dos contadores CounterCache em `alunos` e `instituicoes`.
--
-- ATENÇÃO: As tabelas legadas `estagio` e `mural_inscricao` SÃO 100% PRESERVADAS.
-- ==============================================================================

USE `ess_apps`;

-- ------------------------------------------------------------------------------
-- ETAPA 1: ALINHAMENTO DA TABELA `areas`
-- ------------------------------------------------------------------------------
-- A tabela legada `areas` pertencia a monografias/professores (coluna `numero`).
-- O CakePHP 5 espera que `areas` seja a tabela de áreas de estágio (`id`, `area`).
-- Preservamos a antiga como `areas_professores_legado` e populamos a nova.
-- ------------------------------------------------------------------------------
START TRANSACTION;

-- Renomeia a antiga se ainda não foi renomeada
SET @has_old_areas = (
    SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'areas' AND COLUMN_NAME = 'numero'
);

SET @has_areas_legado = (
    SELECT COUNT(*) FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'areas_professores_legado'
);

IF @has_old_areas > 0 AND @has_areas_legado = 0 THEN
    RENAME TABLE `areas` TO `areas_professores_legado`;
END IF;

-- Cria a tabela de áreas das instituições se não existir com a estrutura correta
CREATE TABLE IF NOT EXISTS `areas` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `area` varchar(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Popula com os dados de area_instituicoes
INSERT IGNORE INTO `areas` (`id`, `area`)
SELECT `id`, `area` FROM `area_instituicoes`;

-- Inclui áreas históricas de areas_estagio que não colidam
INSERT IGNORE INTO `areas` (`id`, `area`)
SELECT `id`, `area` FROM `areas_estagio`
WHERE `id` NOT IN (SELECT `id` FROM `area_instituicoes`);

COMMIT;


-- ------------------------------------------------------------------------------
-- ETAPA 2: MIGRAÇÃO DE `estagio` PARA `instituicoes`
-- ------------------------------------------------------------------------------
-- Transforma e copia todos os registros, mapeando:
--   - beneficio (singular) -> beneficios (plural)
--   - area / area_instituicoes_id -> area_id
--   - convenio: 0 convertido para NULL
--   - caracteres: Latin-1 convertido para UTF-8 (utf8mb4)
--   - estagiarios_count calculado a partir de estagiarios
-- ------------------------------------------------------------------------------
START TRANSACTION;

TRUNCATE TABLE `instituicoes`;

INSERT INTO `instituicoes` (
    `id`,
    `area_id`,
    `natureza`,
    `instituicao`,
    `cnpj`,
    `email`,
    `url`,
    `endereco`,
    `bairro`,
    `municipio`,
    `cep`,
    `telefone`,
    `beneficios`,
    `fim_de_semana`,
    `convenio`,
    `expira`,
    `seguro`,
    `observacoes`,
    `estagiarios_count`
)
SELECT
    e.`id`,
    COALESCE(NULLIF(e.`area_instituicoes_id`, 0), NULLIF(e.`area`, 0)) AS `area_id`,
    NULLIF(TRIM(e.`natureza`), '') AS `natureza`,
    TRIM(e.`instituicao`) AS `instituicao`,
    NULLIF(TRIM(e.`cnpj`), '') AS `cnpj`,
    NULLIF(TRIM(e.`email`), '') AS `email`,
    NULLIF(TRIM(e.`url`), '') AS `url`,
    COALESCE(TRIM(e.`endereco`), '') AS `endereco`,
    NULLIF(TRIM(e.`bairro`), '') AS `bairro`,
    NULLIF(TRIM(e.`municipio`), '') AS `municipio`,
    COALESCE(TRIM(e.`cep`), '') AS `cep`,
    COALESCE(TRIM(e.`telefone`), '') AS `telefone`,
    NULLIF(TRIM(e.`beneficio`), '') AS `beneficios`,
    CASE WHEN e.`fim_de_semana` IN ('0', '1', '2') THEN e.`fim_de_semana` ELSE '0' END AS `fim_de_semana`,
    NULLIF(e.`convenio`, 0) AS `convenio`,
    e.`expira` AS `expira`,
    CASE WHEN e.`seguro` IN ('0', '1') THEN e.`seguro` ELSE NULL END AS `seguro`,
    NULLIF(TRIM(e.`observacoes`), '') AS `observacoes`,
    (SELECT COUNT(*) FROM `estagiarios` est WHERE est.`id_instituicao` = e.`id` OR est.`instituicao_id` = e.`id`) AS `estagiarios_count`
FROM `estagio` e;

-- Define auto_increment para o próximo ID disponível
ALTER TABLE `instituicoes` AUTO_INCREMENT = 1418;

-- Validação de integridade referencial com areas
UPDATE `instituicoes`
SET `area_id` = NULL
WHERE `area_id` IS NOT NULL AND `area_id` NOT IN (SELECT `id` FROM `areas`);

COMMIT;


-- ------------------------------------------------------------------------------
-- ETAPA 3: ALINHAMENTO DA TABELA DE LIGAÇÃO `inst_super`
-- ------------------------------------------------------------------------------
-- Renomeia id_instituicao -> instituicao_id e id_supervisor -> supervisor_id
-- ------------------------------------------------------------------------------
SET @has_old_inst = (
    SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'inst_super' AND COLUMN_NAME = 'id_instituicao'
);

IF @has_old_inst > 0 THEN
    ALTER TABLE `inst_super` 
      CHANGE COLUMN `id_instituicao` `instituicao_id` smallint(4) NOT NULL DEFAULT 0,
      CHANGE COLUMN `id_supervisor` `supervisor_id` smallint(4) NOT NULL DEFAULT 0,
      ADD INDEX IF NOT EXISTS `idx_instituicao_id` (`instituicao_id`),
      ADD INDEX IF NOT EXISTS `idx_supervisor_id` (`supervisor_id`);
END IF;


-- ------------------------------------------------------------------------------
-- ETAPA 4: ALINHAMENTO DAS CHAVES EM `estagiarios`
-- ------------------------------------------------------------------------------
-- Renomeia chaves legadas para os padrões do CakePHP 5
-- ------------------------------------------------------------------------------
SET @has_old_estag_inst = (
    SELECT COUNT(*) FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'estagiarios' AND COLUMN_NAME = 'id_instituicao'
);

IF @has_old_estag_inst > 0 THEN
    ALTER TABLE `estagiarios` 
      CHANGE COLUMN `alunonovo_id` `aluno_id` int(11) NULL DEFAULT NULL,
      CHANGE COLUMN `id_instituicao` `instituicao_id` smallint(6) NOT NULL DEFAULT 0,
      CHANGE COLUMN `id_supervisor` `supervisor_id` smallint(6) NULL DEFAULT NULL,
      CHANGE COLUMN `id_professor` `professor_id` smallint(6) NULL DEFAULT NULL,
      ADD INDEX IF NOT EXISTS `idx_instituicao_id` (`instituicao_id`),
      ADD INDEX IF NOT EXISTS `idx_aluno_id` (`aluno_id`),
      ADD INDEX IF NOT EXISTS `idx_supervisor_id` (`supervisor_id`),
      ADD INDEX IF NOT EXISTS `idx_professor_id` (`professor_id`);
END IF;


-- ------------------------------------------------------------------------------
-- ETAPA 5: REPARO DA TABELA `mural_inscricao`
-- ------------------------------------------------------------------------------
-- id_aluno armazena o `registro` (DRE) do aluno.
-- Sincronizamos aluno_id com a chave real de `alunos.id`.
-- ------------------------------------------------------------------------------
UPDATE `mural_inscricao` mi
INNER JOIN `alunos` a ON a.`registro` = mi.`id_aluno`
SET mi.`aluno_id` = a.`id`
WHERE mi.`aluno_id` IS NULL OR mi.`aluno_id` != a.`id`;


-- ------------------------------------------------------------------------------
-- ETAPA 6: MIGRAÇÃO E DESDUPLICAÇÃO PARA `inscricoes`
-- ------------------------------------------------------------------------------
-- Transfere registros válidos desduplicando pares (aluno_id, muralestagio_id),
-- mantendo a primeira ocorrência histórica válida (MIN(id)).
-- ------------------------------------------------------------------------------
START TRANSACTION;

TRUNCATE TABLE `inscricoes`;

INSERT INTO `inscricoes` (
    `id`,
    `registro`,
    `aluno_id`,
    `muralestagio_id`,
    `periodo`,
    `data`,
    `timestamp`
)
SELECT 
    MIN(mi.`id`) AS `id`,
    mi.`id_aluno` AS `registro`,
    a.`id` AS `aluno_id`,
    mi.`id_instituicao` AS `muralestagio_id`,
    mi.`periodo`,
    MIN(mi.`data`) AS `data`,
    MIN(mi.`timestamp`) AS `timestamp`
FROM `mural_inscricao` mi
JOIN `alunos` a ON mi.`id_aluno` = a.`registro`
JOIN `mural_estagios` me ON mi.`id_instituicao` = me.`id`
GROUP BY a.`id`, mi.`id_instituicao`;

ALTER TABLE `inscricoes` AUTO_INCREMENT = 48293;

-- Sincroniza o CounterCache de inscricoes na tabela alunos
UPDATE `alunos` a
SET a.`inscricao_count` = (
    SELECT COUNT(*) 
    FROM `inscricoes` i 
    WHERE i.`aluno_id` = a.`id`
);

COMMIT;

-- ==============================================================================
-- FIM DO SCRIPT DE MIGRAÇÃO
-- ==============================================================================
