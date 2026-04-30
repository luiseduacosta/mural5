<?php
declare(strict_types=1);

use Faker\Factory as FakerFactory;
use Migrations\BaseSeed;

class EstagiariosSeed extends BaseSeed
{
    public function getDependencies(): array
    {
        return [
            ConfiguracoesSeed::class,
            InstituicoesSeed::class,
            ComplementosSeed::class,
            ProfessoresSeed::class,
            SupervisoresSeed::class,
            AlunosSeed::class,
        ];
    }

    public function run(): void
    {
        if (
            !$this->hasTable('estagiarios')
            || !$this->hasTable('alunos')
            || !$this->hasTable('instituicoes')
            || !$this->hasTable('professores')
            || !$this->hasTable('supervisores')
            || !$this->hasTable('complementos')
        ) {
            return;
        }

        $count = (int)($this->fetchRow('SELECT COUNT(*) AS total FROM estagiarios')['total'] ?? 0);
        if ($count > 0) {
            return;
        }

        $config = $this->fetchRow('SELECT mural_periodo_atual FROM configuracoes ORDER BY id ASC LIMIT 1');
        $periodo = (string)($config['mural_periodo_atual'] ?? '2026-1');

        $alunos = $this->fetchAll('SELECT id, registro FROM alunos ORDER BY id ASC LIMIT 120');
        $instituicoes = $this->fetchAll('SELECT id FROM instituicoes ORDER BY id ASC');
        $professores = $this->fetchAll('SELECT id FROM professores ORDER BY id ASC');
        $supervisores = $this->fetchAll('SELECT id FROM supervisores ORDER BY id ASC');
        $complementos = $this->fetchAll('SELECT id FROM complementos ORDER BY id ASC');

        if (!$alunos || !$instituicoes || !$professores || !$supervisores || !$complementos) {
            return;
        }

        $instituicaoIds = array_map(static fn (array $r): int => (int)$r['id'], $instituicoes);
        $professorIds = array_map(static fn (array $r): int => (int)$r['id'], $professores);
        $supervisorIds = array_map(static fn (array $r): int => (int)$r['id'], $supervisores);
        $complementoIds = array_map(static fn (array $r): int => (int)$r['id'], $complementos);

        $faker = FakerFactory::create('pt_BR');

        $rows = [];
        foreach ($alunos as $aluno) {
            $tc = $faker->optional(0.7)->randomElement(['0', '1']);

            $rows[] = [
                'aluno_id' => (int)$aluno['id'],
                'registro' => (int)$aluno['registro'],
                'nivel' => $faker->randomElement(['1', '2', '3', '4']),
                'tc' => $tc,
                'tc_solicitacao' => $tc === '1' ? $faker->dateTimeBetween('-180 days', '-10 days')->format('Y-m-d') : null,
                'instituicao_id' => $faker->randomElement($instituicaoIds),
                'supervisor_id' => $faker->randomElement($supervisorIds),
                'professor_id' => $faker->randomElement($professorIds),
                'periodo' => $periodo,
                'nota' => $faker->optional(0.6)->randomFloat(2, 0, 10),
                'ch' => $faker->optional(0.8)->numberBetween(120, 600),
                'observacoes' => $faker->optional(0.25)->sentence(),
                'complemento_id' => $faker->randomElement($complementoIds),
                'ajuste2020' => '1',
                'benetransporte' => $faker->optional(0.6)->boolean(),
                'benealimentacao' => $faker->optional(0.6)->boolean(),
                'benebolsa' => $faker->optional(0.4)->numerify('####'),
            ];
        }

        $this->insert('estagiarios', $rows);
    }
}
