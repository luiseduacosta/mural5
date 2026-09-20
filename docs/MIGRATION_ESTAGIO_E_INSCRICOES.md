# Documentação de Migração: `estagio` ➔ `instituicoes` e `mural_inscricao` ➔ `inscricoes`

**Data de Execução**: 20 de Setembro de 2026  
**Ambiente**: Mural de Estágios ESS/UFRJ (Mural5 - CakePHP 5 / PHP 8.5 / MariaDB / MySQL)  
**Banco de Dados**: `ess_apps`  
**Script SQL Reprodutível**: [migrate_estagio_and_inscricoes.sql](file:///home/luis/html/mural5/docs/migrate_estagio_and_inscricoes.sql)

---

## 1. Contexto e Motivação

O sistema **Mural5** foi modernizado para o CakePHP 5, exigindo convenções estritas de ORM (nomes no plural, chaves estrangeiras com padrão `{singular}_id`, codificação UTF-8 `utf8mb4` e comportamentos como `CounterCache`).

O banco de dados possuía tabelas legadas com dados históricos essenciais:
1. `estagio`: Continha 607 instituições de estágio da versão antiga, enquanto a tabela `instituicoes` estava vazia.
2. `mural_inscricao`: Continha 47.339 inscrições de estudantes em vagas do mural com várias anomalias de modelagem, enquanto a tabela moderna `inscricoes` estava vazia.

**Requisito Fundamental**: As tabelas legadas (`estagio` e `mural_inscricao`) **não poderiam ser excluídas nem renomeadas**, devendo ser preservadas para histórico e auditoria.

---

## 2. Migração 1: `estagio` para `instituicoes`

### 2.1 Anomalias Identificadas na Tabela Legada
- **Codificação**: A tabela `estagio` utilizava `latin1_swedish_ci`, gerando problemas em acentos UTF-8.
- **Nomenclatura**: O campo de benefícios chamava-se `beneficio` (singular), mas o CakePHP 5 esperava `beneficios` (plural).
- **Áreas**: Havia dois campos concorrentes: `area` e `area_instituicoes_id`.
- **Campos Obsoletos**: Colunas `fax`, `avaliacao` e `localInscricao` não existem no novo modelo de `instituicoes`.
- **Convênio**: Valores `0` representavam "sem convênio na PR4" e precisavam ser convertidos para `NULL` (já que o campo é opcional e valida número inteiro positivo).
- **Contador**: O campo `estagiarios_count` estava totalmente `NULL` em todas as linhas.

### 2.2 Regras de Transformação Aplicadas
- **Chaves Primárias**: IDs mantidos exatamente de 1 a 1417 (garantindo integridade com estágios já existentes).
- **Área**: `area_id = COALESCE(NULLIF(area_instituicoes_id, 0), NULLIF(area, 0))`.
- **Benefícios**: Mapeado de `beneficio` para `beneficios`.
- **Transcodificação**: MySQL converteu os bytes Latin-1 para `utf8mb4` de forma nativa.
- **Contador de Estagiários**: Calculado dinamicamente:
  ```sql
  (SELECT COUNT(*) FROM estagiarios WHERE instituicao_id = estagio.id)
  ```
- **Auto Incremento**: Ajustado para `1418` (`ALTER TABLE instituicoes AUTO_INCREMENT = 1418;`).

---

## 3. Alinhamento de Tabelas Relacionadas

### 3.1 Tabela `areas`
- **Problema**: No banco `ess_apps`, a tabela `areas` possuía colunas de monografias (`numero`, `area`), fazendo com que `Instituicoes->contain(['Areas'])` gerasse erro `Unknown column 'Areas.id' in 'ON'`.
- **Solução**: 
  1. A tabela antiga foi preservada como `areas_professores_legado`.
  2. Foi criada a tabela `areas` (`id`, `area`) a partir de `area_instituicoes` (20 áreas ativas) e áreas históricas de `areas_estagio` (Assistência, Saúde Coletiva, etc.).

### 3.2 Tabela de Ligação `inst_super`
- **Problema**: As colunas chamavam-se `id_instituicao` e `id_supervisor`. A consulta de supervisores vinculados (`$instituicao->supervisores`) falhava ao procurar `instituicao_id`.
- **Solução**:
  ```sql
  ALTER TABLE `inst_super` 
    CHANGE COLUMN `id_instituicao` `instituicao_id` smallint(4) NOT NULL DEFAULT 0,
    CHANGE COLUMN `id_supervisor` `supervisor_id` smallint(4) NOT NULL DEFAULT 0,
    ADD INDEX `idx_instituicao_id` (`instituicao_id`),
    ADD INDEX `idx_supervisor_id` (`supervisor_id`);
  ```

### 3.3 Tabela `estagiarios`
- **Problema**: As chaves estrangeiras chamavam-se `id_instituicao`, `id_supervisor`, `id_professor` e `alunonovo_id`. A aba de estagiários em `instituicoes/view/{id}` falhava ao buscar `Estagiarios.instituicao_id`.
- **Solução**:
  ```sql
  ALTER TABLE `estagiarios` 
    CHANGE COLUMN `alunonovo_id` `aluno_id` int(11) NULL DEFAULT NULL,
    CHANGE COLUMN `id_instituicao` `instituicao_id` smallint(6) NOT NULL DEFAULT 0,
    CHANGE COLUMN `id_supervisor` `supervisor_id` smallint(6) NULL DEFAULT NULL,
    CHANGE COLUMN `id_professor` `professor_id` smallint(6) NULL DEFAULT NULL,
    ADD INDEX `idx_instituicao_id` (`instituicao_id`),
    ADD INDEX `idx_aluno_id` (`aluno_id`),
    ADD INDEX `idx_supervisor_id` (`supervisor_id`),
    ADD INDEX `idx_professor_id` (`professor_id`);
  ```

---

## 4. Migração 2: `mural_inscricao` para `inscricoes`

### 4.1 Diagnóstico Crítico da Tabela `mural_inscricao`
1. **DRE armazenado no lugar do ID**: A coluna `id_aluno` continha, na verdade, o **DRE (`registro`)** do estudante.
2. **Coluna `aluno_id` corrompida**: A coluna `aluno_id` existente no banco continha IDs arbitrários (apenas 30 de 47.339 batiam com o aluno real).
3. **Chave de Vaga**: A coluna `id_instituicao` continha o ID da vaga no mural (`muralestagio_id`), e não da instituição.
4. **Duplicações Massivas**: Existiam **31.309 registros duplicados** (cargas históricas idênticas repetidas em lotes com IDs espaçados, como `926, 17068, 32385`).

### 4.2 Fase 1: Reparo da Tabela `mural_inscricao`
Atualizamos a coluna `aluno_id` de `mural_inscricao` com o ID real do aluno, fazendo o join por `alunos.registro`:
```sql
UPDATE `mural_inscricao` mi
INNER JOIN `alunos` a ON a.`registro` = mi.`id_aluno`
SET mi.`aluno_id` = a.`id`
WHERE mi.`aluno_id` IS NULL OR mi.`aluno_id` != a.`id`;
```
- **Resultado**: 47.262 registros sincronizados com o aluno correto. Apenas 77 registros legados pertenciam a DREs não cadastrados na tabela `alunos`.

### 4.3 Fase 2: Migração e Desduplicação para `inscricoes`
Conforme o algoritmo de referência `repair_inscricoes.py`, os dados foram migrados agrupando por `(aluno_id, muralestagio_id)` e mantendo o primeiro registro histórico válido (`MIN(id)`):
```sql
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
```
- **Resultado**: Exatamente **16.001 registros limpos e consistentes** inseridos. Zero duplicatas.

### 4.4 Sincronização do CounterCache de Alunos
```sql
UPDATE `alunos` a
SET a.`inscricao_count` = (
    SELECT COUNT(*) 
    FROM `inscricoes` i 
    WHERE i.`aluno_id` = a.`id`
);
```
- A soma de `inscricao_count` em `alunos` totalizou exatamente **16.001**.

---

## 5. Resumo Numérico das Tabelas

| Tabela | Registros | Função | Status |
| :--- | :--- | :--- | :--- |
| `estagio` | 607 | Origem legada de instituições | **Preservada intacta** |
| `instituicoes` | 607 | Modelo oficial CakePHP 5 | **Ativa e consistente** |
| `inst_super` | 1.834 | Junção Instituição ↔ Supervisor | **Colunas alinhadas** |
| `estagiarios` | 7.889 | Estágios vinculados | **Colunas alinhadas** |
| `mural_inscricao` | 47.339 | Origem legada de inscrições | **Preservada intacta** (`aluno_id` reparado) |
| `inscricoes` | 16.001 | Modelo oficial CakePHP 5 | **Ativa e desduplicada** |
| `areas` | 24 | Áreas de estágio | **Alinhada com `id`** |
| `areas_professores_legado` | 95 | Áreas antigas de monografia | **Preservada intacta** |

---

## 6. Como Reproduzir a Migração

Para executar ou reaplicar todo o procedimento em outro ambiente (ex: homologação ou produção), basta executar o script SQL fornecido:

```bash
mysql -u root -p ess_apps < docs/migrate_estagio_and_inscricoes.sql
bin/cake cache clear_all
```
